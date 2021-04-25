<?php
use BookWorms\Model\Customer;

$customers = Customer::findAll();
$numCustomers = count($customers);
$pageSize = 10;
$numPages = ceil($numCustomers / $pageSize);
?>
<table class="table" id="table-customers">
    <thead>
        <tr>
            <th>Customer Id</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($customers as $customer) { ?>
            <tr>
                <td><?= $customer->id ?></td>
                <td><?= $customer->name ?></td>
                <td><?= $customer->phone ?></td>
                <td><?= $customer->address ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<nav id="nav-products">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="#" data-page="previous">
                &laquo;
            </a>
        </li>
        <?php for ($i = 0; $i < $numPages; $i++) { ?>
            <li class="page-item">
                <a class="page-link" href="#" data-page="<?= $i + 1 ?>">
                    <?= $i + 1 ?>
                </a>
            </li>
        <?php } ?>
        <li class="page-item">
            <a class="page-link" href="#" data-page="next">
                &raquo;
            </a>
        </li>
    </ul>
</nav>