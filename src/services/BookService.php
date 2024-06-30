<?php

namespace src\services;

use PDOException;
use src\database\LocalInstance;
use src\repositories\BookRepository;
use src\requests\books\BookStoreRequest;
use src\support\Notification;
use src\support\Redirect;
use stdClass;

class BookService
{

    function __construct(
        private BookRepository $bookRepository,
        private LocalInstance $localInstance,
        private Notification $notification
    ) {
        $this->bookRepository = $this->bookRepository->configDatabase($this->localInstance->db());
    }

    function get(): stdClass
    {
        return $this->bookRepository->get();
    }

    /**
     * @param BookStoreRequest $request
     * @return Redirect
     */
    function store(BookStoreRequest $request): Redirect
    {
        try {
            $this->bookRepository->transactionBegin();
            $this->bookRepository->store($request->get());
            $this->bookRepository->transactionCommit();

            $this->notification->success("Livro salvo com sucesso");
        } catch (PDOException $e) {
            $this->notification->error("Whoops, não foi possível salvar os dados do livro");
        } finally {
            return Redirect::to("/books");
        }
    }
}
