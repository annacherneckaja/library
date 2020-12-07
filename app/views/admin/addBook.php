
<section id="main" class="main-wrapper">
    <div class="container">
        <form action="admin/addBook" method="POST"
        ">
        <div class="form-group">
            <label for="name"><h1>Add book</h1></label>
        </div>
        <div class="form-group">
            <label for="name">Book title</label>
            <input type="text" class="form-control" required name="name" value="">
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col">
                    <label for="author[]">Author</label>
                    <input type="text" class="form-control" name="author[]" value="">
                </div>
                <div class="col">
                    <label for="author[]">Author</label>
                    <input type="text" class="form-control" name="author[]" value="">
                </div>
                <div class="col">
                    <label for="author[]">Author</label>
                    <input type="text" class="form-control" name="author[]" value="">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="pages">Pages</label>
                    <input type="text" class="form-control" name="pages" value="">
                </div>
                <div class="col">
                    <label for="year">Year</label>
                    <div class="form-group">
                        <select class="custom-select" name="year">
                            <option value=""></option>
                            <?php
                            for ($i = 1990; $i < 2021; $i++):
                                ?>
                                <option value="<?php echo$i ?>" name="year"><?php echo$i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <label for="isbn">isbn</label>
                    <input type="text" class="form-control" name="isbn" value="">
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="5" id="comment"></textarea>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Image</label>
                        <div class="custom-file">
                            Choose image
                            <input type="file" class="custom-file-input" name="image" onchange="readURL(this);"/>
                            <label class="custom-file-label" for="image">Choose image</label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <img id="blah"/>
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>

            </form>
        </div>
</section>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(250);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>