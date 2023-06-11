<div class="pagenate">
    <?php if ($data["current_page"] >= 3) : ?>
        <a href="?page=1" class="page_arrow">≪</a>
    <?php endif; ?>
    <?php if ($data["current_page"] >= 2) : ?>
        <a href="?page=<?= $data["current_page"] - 1; ?>" class="page_arrow">&lt;</a>
    <?php endif; ?>
    <?php if ($data["current_page"] >= 4) : ?>
        <span class="page_dots">...</span>
    <?php endif; ?>

    <?php foreach ($data["around_pages"] as $num) : ?>
        <?php if ($num !== $data["current_page"]) : ?>
            <a href="?page=<?= $num; ?>" class="page_btn"><?= $num; ?></a>
        <?php else : ?>
            <p class="page_btn current_btn"><?= $num; ?></p>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if ($data["current_page"] <= ($data["total_pages"] - 3)) : ?>
        <span class="page_dots">...</span>
    <?php endif; ?>
    <a href=""></a>
    <?php if ($data["current_page"] <= $data["total_pages"] - 1) : ?>
        <a href="?page=<?= $data["current_page"] + 1; ?>" class="page_arrow">&gt;</a>
    <?php endif; ?>
    <?php if ($data["current_page"] <= ($data["total_pages"] - 2)) : ?>
        <a href="?page=<?= $data["total_pages"]; ?>" class="page_arrow">≫</a>
    <?php endif; ?>
</div>
