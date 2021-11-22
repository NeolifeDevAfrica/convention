<div class="container mt-5">

    <div class="row">

        <div class="col-6">

         <div class="card text-white bg-success mb-3">
            <div class="card-header">Present All Time</div>
            <div class="card-body">
                <h1 class="card-title"><?=number_format($present) ?></h1>
                <p class="card-text">Last Updated <?=date('Y-m-d H:i:s') ?></p>
            </div>
        </div>

    </div>

    <div class="col-6">

     <div class="card text-white bg-danger mb-3">
        <div class="card-header">Absent All Time</div>
        <div class="card-body">
            <h1 class="card-title"><?=number_format($absent )?></h1>
            <p class="card-text">Last Updated <?=date('Y-m-d H:i:s') ?></p>
        </div>
    </div>

</div>

<hr>

</div>


<div class="row">

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">PRESENT - DETAILS BY DAYS</h3>
                    </th>
                </tr>
                <tr>
                    <th>DATE</th>
                    <th>PRESENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($present_details as $row): ?>
                    <tr>
                        <td><?=date('l, jS M', strtotime($row->date)) ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">PRESENT - DETAILS BY DAYS & ITEM CODE</h3>
                    </th>
                </tr>
                <tr>
                    <th>DATE</th>
                    <th>ITEMCODE</th>
                    <th>PRESENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($present_details as $row): ?>
                    <tr>
                        <td><?=date('l, jS M', strtotime($row->date)) ?></td>
                        <td><?=$row->item_code ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">PRESENT - DETAILS BY DAYS & USER</h3>
                    </th>
                </tr>
                <tr>
                    <th>DATE</th>
                    <th>USER</th>
                    <th>PRESENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($present_details_users as $row): ?>
                    <tr>
                        <td><?=date('l, jS M', strtotime($row->date)) ?></td>
                        <td><?=DB::firstOrNew('users', ['id' => $row->user_id])->name ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">ABSENT - DETAILS BY ITEM CODE</h3>
                    </th>
                </tr>
                <tr>
                    <th>ITEMCODE</th>
                    <th>ABSENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($absent_details as $row): ?>
                    <tr>
                        <td><?=$row->item_code ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">PRESENT - DETAILS BY PT</h3>
                    </th>
                </tr>
                <tr>
                    <th>PT NAME</th>
                    <th>PRESENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($present_teams as $row): ?>
                    <tr>
                        <td><?=$row->pt ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <div class="col-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="3">
                        <h3 class="text-center">ABSENT - DETAILS BY PT</h3>
                    </th>
                </tr>
                <tr>
                    <th>PT NAME</th>
                    <th>ABSENT</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($absent_teams as $row): ?>
                    <tr>
                        <td><?=$row->pt ?></td>
                        <td><?=number_format($row->count) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>
</div>