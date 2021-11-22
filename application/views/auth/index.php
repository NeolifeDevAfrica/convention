<div class="container mt-5">
    <div class="row">
        <div class="offset-2 col-8">

            <div class="card mb-3">
                <div class="card-header"><h3>Start Journey</h3></div>
                <div class="card-body">

                    <form action="<?=site_url('auth') ?>" method="POST" role="form">

                        <?php if($this->session->has_userdata('error')): ?>
                            <div class="alert alert-danger">
                                <?=$this->session->userdata('error') ?>
                            </div>
                        <?php endif ?>

                        <div class="form-group">
                            <label>Choose Terminal</label>
                            <select name="user_id" class="form-control" required>
                                <?php foreach($users as $row): ?>
                                    <option value="<?=$row->id ?>"><?=$row->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>