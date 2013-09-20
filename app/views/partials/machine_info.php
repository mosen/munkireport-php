<div class="well well-small">
	<?$machine = new Machine($serial_number)?>
	<?$report   = new Reportdata($serial_number)?>
	<?$disk   = new disk_report_model($serial_number)?>
	<?$warranty   = new Warranty($serial_number)?>
	<?//todo: make 1 query?>
	<div class="row">
		<div class="col-lg-1">
			<img width="72" height="72" src="https://km.support.apple.com.edgekey.net/kb/securedImage.jsp?configcode=<?=substr($serial_number, 8)?>&amp;size=120x120" />
		</div>
		<div class="col-lg-3">
			<h4>
				<?=$machine->computer_name?><br />
			</h4>
			<small class="muted">
				<?=$machine->machine_desc?>
				<?=$machine->machine_model?>
				<br />
				<?=$report->long_username?>
				<?if($report->console_user):?>
				(<?=$report->console_user?>)
				<?endif?>
				<br />
				Warranty Coverage: 
				<?if ($warranty->status == "Supported"):?>
					<span class='text-success'>Supported until 
						<?=$warranty->end_date?>
					</span>
				<?elseif ($warranty->status == "No Applecare"):?>
					<span class='text-warning'>No Applecare until 
						<?=$warranty->end_date?>
					</span>
				<?elseif ($warranty->status == "Unregistered serialnumber"):?>
					<span class='text-warning'>Unregistered</span>
					<a target="_blank" href="https://selfsolve.apple.com/RegisterProduct.do?productRegister=Y&amp;country=USA&amp;id=<?=$serial_number?>">Register</a>
				<?elseif ($warranty->status == "Expired"):?>
					<span class='text-danger'>Expired on 
						<?=$warranty->end_date?>
					</span>
				<?else:?>
					<span class='text-danger'><?=$warranty->status?></span>
				<?endif?>

				</small>
				<hr />
				<a class="btn btn-default btn-xs" href="<?php echo url('clients/recheck_warranty/' . $serial_number);?>">
					Recheck Warranty Status
				</a>
				<?if(conf('vnc_link')):?>

				<a class="btn btn-default btn-xs" href="<?printf(conf('vnc_link'), $report->remote_ip)?>">Remote Control (vnc)</a>
				<?endif?>
		</div>
		<div class="col-lg-4">
			<small>
				<dl class="dl-horizontal">
					<dt>Software</dt>
					<dd>OS X <?=$machine->os_version . ' ('
							. $machine->cpu_arch . ')'?>&nbsp;</dd>
					<dt>CPU Speed</dt>
					<dd><?=$machine->current_processor_speed?> ( <?=$machine->number_processors?> core )</dd>
					<dt>Serial Number</dt>
					<dd><?=$serial_number?>&nbsp;</dd>
					<dt>SMC Version</dt>
					<dd><?=$machine->SMC_version_system?>&nbsp;</dd>
					<dt>Boot ROM</dt>
					<dd><?=$machine->boot_rom_version?>&nbsp;</dd>
					<dt>Memory</dt>
					<dd><?=$machine->physical_memory?>&nbsp;</dd>
					<dt>Hardware UUID</dt>
					<dd><?=$machine->platform_UUID?>&nbsp;</dd>
					<dt>Remote IP Address</dt>
					<dd><?=$report->remote_ip;?>&nbsp;</dd>
				</dl>
			</small>
		</div>
		<div class="col-lg-4">
			<small>
				<dl class="dl-horizontal">
					<dt>Disk size</dt>
					<dd><?=humanreadablesize($disk->TotalSize)?></dd>
					<dt>Used</dt>
					<dd><?=humanreadablesize($disk->TotalSize - $disk->FreeSpace)?></dd>
					<dt>Free</dt>
					<dd><?=humanreadablesize($disk->FreeSpace)?></dd>
					<dt>SMART Status</dt>
					<dd><?=$disk->SMARTStatus?></dd>
				</dl>
				<?require_once(APP_ROOT . "app/helpers/warranty_helper.php")?>
				<dl class="dl-horizontal">
					<dt>Est. Manufacture date</dt>
					<dd><?=estimate_manufactured_date($serial_number)?></dd>
					<dt>Est. Purchase date</dt>
					<dd><?=$warranty->purchase_date?></dd>
				</dl>

				<dl class="dl-horizontal">
					<dt>Registration date</dt>
					<dd><time datetime="<?=$report->reg_timestamp?>">..</time></dd>
					<dt>Last checkin</dt>
					<dd><time datetime="<?=$report->timestamp?>">..</time></dd>
				</dl>

				<script>
					$(document).ready(function() {
						$( "dd time" ).each(function( index ) {
							$(this).html(moment($(this).attr('datetime') * 1000).fromNow());
						});
					});
				</script>
				
			</small>
		</div>
	</div>
</div>