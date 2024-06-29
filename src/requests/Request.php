<?php

namespace src\requests;

use src\support\Request as httpRequest;

abstract class Request
{

    function __construct()
    {
        $this->execute();
    }

    /** @var array<string, string> */
    protected array $rules;

    /**
     * This method returns all inputs except the token
     * 
     * @param ?string $key
     * @return array<mixed, mixed>|string
     */
    public function get(?string $key = null): array|string
    {
        if (!$key)
            return httpRequest::excepts(["token"]);
        return $this->input($key);
    }


    /**
     * This method returns an index of Superglobal $ _Post
     * @param string $input
     * @return string|array<mixed, mixed>
     */
    public function input(string $input): string|array
    {
        return httpRequest::input($input);
    }

    /**
     * This method is responsible for returning the validation rules
     * 
     * @return array<string, string>
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Method responsible for performing validation
     * @return array<void>
     */
    public function execute(): array
    {
        if (!formValidate($this->rules())) {
            notification("Whoops! Não foi possível prosseguir com a solicitação.", 'error');
            redirect(url_back());
        }
        return [];
    }
}
