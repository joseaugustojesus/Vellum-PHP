<?= $this->layout("templates/base", [
    "title_in_card" => "Cadastrar Livro",
    "url_back" => route("/books")
]) ?>



<form action="<?= route("/books/store") ?>" method="POST">
    <div class="row g-3">

        <!-- Fields -->
        <div class="col-12 col-md-4">
            <label for="author" class="form-label fw-bold">Autor <span>*</span></label>
            <input id="author" name="author" type="text" class="form-control" placeholder="Example: George Orwell" value="<?= $book->author ?>">
        </div>

        <div class="col-12 col-md-3">
            <label for="publishedAt" class="form-label fw-bold">Publicação <span>*</span></label>
            <input id="publishedAt" name="published_at" type="date" class="form-control" value="<?= timestampToDate($book->published_at) ?>">
        </div>

        <div class="col-12 col-md-5">
            <label for="name" class="form-label fw-bold">Livro <span>*</span></label>
            <input id="name" name="name" type="text" class="form-control" placeholder="Example: A Revolução Dos Bichos" value="<?= $book->name ?>">
        </div>

        <!-- submit -->
        <div class="col-12">
            <button type="submit" class="btn btn-company float-end d-flex align-items-center justify-content-center">Salvar <i class="ph ph-paper-plane-tilt ms-1"></i>

            </button>
        </div>
    </div>
</form>