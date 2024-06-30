<?php

namespace src\controllers;

use PDO;
use src\requests\books\BookStoreRequest;
use src\services\BookService;
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

    function delete(int $id)
    {
        return $this->bookService->delete($id);
    }
}
