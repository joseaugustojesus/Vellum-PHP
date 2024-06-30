<?php

namespace src\services;

use Exception;
use PDOException;
use src\database\LocalInstance;
use src\exceptions\NotFoundException;
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

    function getById(int $id): stdClass|bool
    {
        $book = $this->bookRepository->getById($id);
        if (!$book)
            throw new NotFoundException("Não foi possível encontrar nenhum livro com o ID: {$id}");
        return $book;
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


    /**
     * @param int $id
     * @return Redirect
     */
    function delete(int $id): Redirect
    {
        try {
            $this->bookRepository->destroy($id);
            $this->notification->success("O livro foi deletado com sucesso");
        } catch (PDOException $e) {
            $this->notification->error("Whoops, não foi possível excluir o livro");
        } finally {
            return Redirect::to("/books");
        }
    }
}
