<?php

namespace src\controllers;

use Exception;
use PDO;
use src\requests\books\BookStoreRequest;
use src\services\BookService;
use src\support\Notification;
use src\support\Redirect;
use src\support\View;

class BookController
{

    function __construct(
        private BookService $bookService
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
        return $this->bookService->store($request);
    }

    function delete(int $id): Redirect
    {
        return $this->bookService->delete($id);
    }

    function edit(int $id)
    {
        try {
            return View::render("books.edit", [
                'book' => $this->bookService->getById($id)
            ]);
        } catch (Exception $e) {
            (new Notification)->error($e->getMessage());
            return  Redirect::to('/books');
        }
    }
}
