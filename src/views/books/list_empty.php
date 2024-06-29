
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

            <strong>Whoops 🙁</strong>
            <p class="m-0">Não encontramos nenhum livro, que tal <a href="<?= route("/books/new") ?>" class="text-link">cadastrar um livro?</a></p>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-center">
        <img src="<?= images_directory("books/empty.svg") ?>" class="img-fluid" alt="Imagem que contem uma moça ao lado de uma caixa vazia" style="max-height: 620px;" />
    </div>
</div>