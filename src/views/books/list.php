<table class="mb-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Autor</th>
            <th>Publicação</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($books->paginated as $book) { ?>
            <tr>
                <td><?= $book->id ?></td>
                <td><?= $book->name ?></td>
                <td><?= $book->author ?></td>
                <td><?= dateAmericanToBrazilian($book->published_at) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?= $books->links ?>