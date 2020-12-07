<section id="main" class="main-wrapper">
    <div class="container">
        <form action="admin/editBook" method="POST"">
                <div class="form-group">
                    <label for="name"><h1>Edit book</h1></label>
                    <input type="hidden" name="book_id" value="<?= $vars['book_id']  ?>" />
                </div>
            <div class="form-group">
                <label for="name">Book title</label>
                <input type="text" class="form-control" name="name" value="<?= $vars['name'] ?>">
            </div>
            <div class="form-group">
                <div class="row">
                    <?php
                    $authors = explode(",", $vars['author']);
                    for ($i = 0;$i < 4; $i++):
                    ?>
                    <div class="col">
                        <label for="author[]">Author</label>
                        <input type="text" class="form-control" name="author[]" value=
                        "<?= $i < count($authors)? trim($authors[$i]):'' ?>">
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="pages">Pages</label>
                        <input type="text" class="form-control" name="pages" value="<?= $vars['pages'] ?>">
                    </div>
                    <div class="col">
                        <label for="year">Year</label>
                        <div class="form-group">
                            <select class="custom-select" required name="year">
                                <option value="<?= $vars['year'] ?>"><?= $vars['year'] ?></option>
                                <?php
                                for ($i = 1990;$i < 2021;$i++):
                                    ?>
                                    <option value="<?php echo $i ?>" name="year"><?php echo $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <label for="isbn">isbn</label>
                        <input type="text" class="form-control" name="isbn" value="<?= $vars['isbn'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" rows="5" id="comment"><?= $vars['description'] ?>
                            </textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Image</label>
                            <div class="custom-file">
                                Choose image
                                <input type="file" class="custom-file-input" name="image" onchange="readURL(this);"/>
                                <label class="custom-file-label" for="image">Choose image</label>
                                <script>
                                    // $(".custom-file-input").on("change", function () {
                                    //     var fileName = $(this).val().split("\\").pop();
                                    //     $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                    // });

                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#blah')
                                                    .attr('src', e.target.result)
                                                    .width(150)
                                                    .height(200);
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <img id="blah" src="#" alt="your image"/>


                    </div>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>

        </form>
    </div>
</section>