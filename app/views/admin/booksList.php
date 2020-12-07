<h2 align="center">Books List</h2>

<form>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Book_id</th>
            <th scope="col">Book Title</th>
            <th scope="col">Author</th>
            <th scope="col">Pages</th>
            <th scope="col">Year</th>
            <th scope="col">isbn</th>
            <th scope="col">Click count</th>
            <th scope="col">View count</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vars['books'] as $var): ?>
            <tr>
                <td>
                    <img src="/public/images/<?= $var['image'] ?>"
                         alt="" width="50" height="50" >
                </td>
                <td><?= $var['book_id'] ?></td>
                <td><?= $var['name'] ?></td>
                <td><?= $var['author'] ?></td>
                <td><?= $var['pages'] ?></td>
                <td><?= $var['year'] ?></td>
                <td><?= $var['isbn'] ?></td>
                <td><?= $var['click_count'] ?></td>
                <td><?= $var['view_count'] ?></td>
                <td>
                    <a href="?getBook=<?= $var['book_id'] ?>">
                        <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-pencil-square"
                             fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd"
                                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                    </a>
                </td>
                <td>
                    <a href="?deleteBook=<?= $var['book_id'] ?>">

                        <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd"
                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</form>
<script>
    $(function () {
        $('#btn-tooltip').tooltip();
    })
</script>
<div class="custom-pagination">
        <?php echo $vars['pagination']->getHtmlAll(); ?>
</div>