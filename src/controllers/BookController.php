<?php

namespace src\controllers;

use Exception;
use PDO;
use src\requests\books\BookStoreRequest;
use src\requests\books\BookUpdateRequest;
use src\services\BookService;
use src\support\Notification;
use src\support\Redirect;
use src\support\View;

class BookController
{

    function __construct(
        private BookService $bookService,
        private Notification $notification
    ) {
    }

    function list(): View
    {
        return View::render("books.index", [
            'books' => $this->bookService->get()
        ]);
    }

    function create(): View
    {
        return View::render("books.create", []);
    }

    function store(BookStoreRequest $request): Redirect
    {
        try {
            $this->bookService->store($request);
            $this->notification->success("Livro salvo com sucesso");
        } catch (Exception $e) {
            $this->notification
                ->error($e->getMessage())
                ->info("Error code: {$e->getCode()}");
        }
        return Redirect::to('/books');
    }

    function delete(int $id): Redirect
    {
        try {
            $this->bookService->delete($id);
            $this->notification->success("Livro excluído com sucesso");
        } catch (Exception $e) {
            $this->notification
                ->error($e->getMessage())
                ->info("Error code: {$e->getCode()}");
        }

        return Redirect::to('/books');
    }

    function edit(int $id): View|Redirect
    {
        try {
            return View::render("books.edit", [
                'book' => $this->bookService->getById($id)
            ]);
        } catch (Exception $e) {
            $this->notification
                ->error($e->getMessage())
                ->info("Error code: {$e->getCode()}");
            return  Redirect::to('/books');
        }
    }

    function update(BookUpdateRequest $request): Redirect
    {
        try {
            $this->bookService->update($request);
            $this->notification->success("Livro atualizado com sucesso");
        } catch (Exception $e) {
            $this->notification
                ->error($e->getMessage())
                ->info("Error code: {$e->getCode()}");
        }
        return Redirect::to('/books');
    }
}
