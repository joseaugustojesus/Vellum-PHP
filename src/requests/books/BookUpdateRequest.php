<?php

namespace src\requests\books;

use src\interfaces\RequestInterface;
use src\requests\Request;

class BookUpdateRequest extends Request implements RequestInterface
{
    protected array $rules = [
        'id' => 'required',
        'author' => 'required',
        'published_at' => 'required',
        'name' => 'required',
    ];
}
