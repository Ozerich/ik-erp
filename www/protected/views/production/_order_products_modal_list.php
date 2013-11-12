<table class="products-table-list">
    <thead>
    <tr>
        <th class="cell-num">№</th>
        <th class="cell-articul">Артикул</th>
        <th class="cell-name">Наименование</th>
        <th class="cell-count">Кол-во</th>
        <th class="cell-comment">Комментарий</th>
        <th class="cell-price">Цена</th>
        <th class="cell-amount">Сумма</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($products as $ind => $product): ?>
        <tr>
            <td><?= $ind + 1 ?></td>
            <td><?= $product->product->articul ?></td>
            <td><?= $product->product->name ?></td>
            <td><?= $product->count ?></td>
            <td><?= $product->comment ?></td>
            <td><?= $product->product->price ?></td>
            <td><?= $product->product->price * $product->count ?></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>