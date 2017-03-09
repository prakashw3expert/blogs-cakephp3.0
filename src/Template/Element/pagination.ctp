<?php if ($this->Paginator->counter('{{pages}}') > 1) { ?>
    <div class="pagination-wrapper">
        <ul class="pagination">
            <?php
            $this->Paginator->templates([
                'current' => '<li class="active"><a href="#">{{text}}</a></li>',
                'prevDisabled' => '<li class="hide"><a href="#">{{text}}</a></li>',
                'nextDisabled' => '<li class="hide"><a href="#">{{text}}</a></li>'
            ]);
            ?>
            <?= $this->Paginator->prev('<span aria-hidden="true"><i class="fa fa-long-arrow-left"></i> Previous Page</span>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers(['first' => 2, 'last' => 2, 'before' => false, 'after' => false, 'modulus' => 6]) ?>
            <?= $this->Paginator->next('<span aria-hidden="true">Next Page <i class="fa fa-long-arrow-right"></i></span>', ['escape' => false]) ?>
        </ul>
    </div>
<?php } ?>
