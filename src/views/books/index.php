<?= $this->layout("templates/base", [
    "title_in_card" => "Meus Livros Preferidos",
    "styles" => [
        css_directory("/table-responsive.css")
    ]
]) ?>

<?php if (empty($books)) {
    $this->insert("books/empty");
} else {  ?>

    <div class="row mb-3">
        <div class="col-12">
            <a href="<?= route("/books/new") ?>" class="btn btn-company float-end d-flex align-items-center">Novo Livro <i class="ph ph-stack-plus ms-2"></i></a>
        </div>
    </div>


    <?= $this->insert("books/list"); ?>
<?php
}
?>