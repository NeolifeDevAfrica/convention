<div class="container mt-5">
	<div class="row">
		<div class="offset-2 col-8">

			<div class="card mb-3">
				<div class="card-header"><h3>Draw Options</h3></div>
				<div class="card-body">

					<form action="<?=site_url('draws/form') ?>" method="POST" role="form">

						<?php if($this->session->has_userdata('error')): ?>
							<div class="alert alert-danger">
								<?=$this->session->userdata('error') ?>
							</div>
						<?php endif ?>

						<div class="form-group">
							<label>Date Present</label>
							<select class="form-control" required>
								<option value="0">Only Present today <?=date('l, jS M') ?></option>
							</select>
						</div>

						<div class="form-group">
							<label>Item Code</label>
							<table class="table table-sm">
								<tbody>
									<?php foreach([294, 295, 296, 297, 408] as $row): ?>
										<tr>
											<td style="width:10px"><input type="checkbox" name="item_codes[]" value="<?=$row ?>" checked></td>
											<td><?=$row ?? 'None' ?></td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							<label>Rank</label>
							<table class="table table-sm">
								<tbody>
									<?php foreach($ranks as $row): ?>
										<?php if(strlen($row->rank_description) > 0 && $row->rank_description != 'None'): ?>
											<tr>
												<td style="width:10px"><input type="checkbox" name="ranks[]" value="<?=$row->rank_description ?>" checked></td>
												<td><?=$row->rank_description ?></td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							<label>Minimum July PPV</label>
							<input type="number" name="july_ppv" class="form-control" placeholder="Minimum 201907 PPV">
						</div>

						<div class="form-group">
							<label>Minimum August PPV</label>
							<input type="number" name="august_ppv" class="form-control" placeholder="Minimum 201908 PPV">
						</div>

						<div class="form-group">
							<label>Minimum July Personal Sponsoring</label>
							<input type="number" name="july_sponsoring" class="form-control" placeholder="Minimum July Personal Sponsoring">
						</div>

						<div class="form-group">
							<label>Minimum August Personal Sponsoring</label>
							<input type="number" name="august_sponsoring" class="form-control" placeholder="Minimum August Personal Sponsoring">
						</div>

						

						<button type="submit" class="btn btn-primary btn-lg btn-block">Filter</button>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>