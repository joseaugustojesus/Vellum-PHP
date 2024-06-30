<table class="mb-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Autor</th>
            <th>Publicação</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($books->paginated as $book) { ?>
            <tr>
                <td><?= $book->id ?></td>
                <td><?= $book->name ?></td>
                <td><?= $book->author ?></td>
                <td><?= dateAmericanToBrazilian($book->published_at) ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="<?= route("/books/edit/{$book->id}") ?>" class="btn btn-warning"><i class="ph ph-pencil"></i></a>
                        <button type="button" class="btn btn-danger" onclick="confirm.destroy(this)" data-id="<?= $book->id ?>"><i class="ph ph-trash"></i></button>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?= $books->links ?>