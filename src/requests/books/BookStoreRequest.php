<?php

namespace src\requests\books;

use src\interfaces\RequestInterface;
use src\requests\Request;

class BookStoreRequest extends Request implements RequestInterface
{
    protected array $rules = [
        'author' => 'required',
        'published_at' => 'required',
        'name' => 'required',
    ];
}
