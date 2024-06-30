<?php

namespace src\services;

use Exception;
use PDOException;
use src\database\LocalInstance;
use src\exceptions\NotFoundException;
use src\exceptions\SaveFailedException;
use src\repositories\BookRepository;
use src\requests\books\BookStoreRequest;
use src\requests\books\BookUpdateRequest;
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
            throw new NotFoundException("Não foi possível encontrar nenhum livro com o ID: {$id}", 404);
        return $book;
    }

    /**
     * @param BookStoreRequest $request
     * @return void
     */
    function store(BookStoreRequest $request): void
    {
        $this->bookRepository->store($request->get());
    }


    /**
     * @param int $id
     * @return void
     */
    function delete(int $id): void
    {
        $this->getById($id);
        $this->bookRepository->destroy($id);
    }


    /**
     * @param BookUpdateRequest $request
     * @return void
     */
    function update(BookUpdateRequest $request): void
    {
        $book = $this->getById($request->get('id'));
        $this->bookRepository->rebuild($book->id, $request->get());
    }
}
