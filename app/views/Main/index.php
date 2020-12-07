<section id="main" class="main-wrapper">
    <div class="container">
    <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach ($vars['books'] as $var): ?>
                <div data-book-id=".<?= $var['book_id'] ?>." class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <div class="book">
                        <a href="http://library.com/book/<?= $var['book_id'] ?>">
                            <img src="/public/images/<?= $var['image'] ?>" alt="<?= $var['image'] ?>">
                            <div data-title="<?= $var['name'] ?>" class="blockI" style="height: 46px;">
                                <div data-book-title="<?= $var['name'] ?>" class="title size_text">
                                    <?= $var['name'] ?>
                                </div>
                                <div data-book-author="<?= $var['author'] ?>" class="author">
                                    <?= $var['author'] ?>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="custom-pagination">
            <?php echo $vars['pagination']?>
    </div>


</section>