
<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="book_block col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="id">
                <div id="bookImg" class="col-xs-12 col-sm-3 col-md-3 item">
                    <img src="/public/images/<?= $vars['image'] ?>" alt="Responsive image" class="img-responsive">
                    <hr>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 info">
                    <div class="bookInfo col-md-12">
                        <div id="title" class="titleBook"><?= $vars['name'] ?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="bookLastInfo">
                            <div class="bookRow"><span class="properties">автор:</span><span
                                        id="author"><?= $vars['author'] ?></span>
                            </div>
                            <div class="bookRow"><span class="properties">год:</span><span
                                        id="year"><?= $vars['year'] ?></span></div>
                            <div class="bookRow"><span class="properties">страниц:</span><span
                                        id="pages"><?= $vars['pages'] ?></span>
                            </div>
                            <div class="bookRow"><span class="properties">isbn:</span><span
                                        id="isbn"><?= $vars['isbn'] ?></span></div>
                        </div>
                    </div>
                    <div class="bookDescription col-xs-12 col-sm-12 col-md-12 hidden-xs hidden-sm">
                        <h4>О книге</h4>
                        <hr>
                        <p id="description"><?= $vars['description'] ?></p>
                    </div>
                    <div class="btnBlock col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btn btn-primary" id="click_count">
                            Хочу читать!
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).on("click", "#click_count", function () {
        $.ajax({
            url: "http://library.com/main/click",
            type: "POST",
            cache: false,
            data: {
                id: <?= $vars['book_id'] ?>,
            },
            success: function (dataResult) {
                alert('Прекрасный выбор! Звони нам!');
            }
        });
    });
</script>


