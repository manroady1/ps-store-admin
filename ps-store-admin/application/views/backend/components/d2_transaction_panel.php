 <!-- TABLE: LATEST ORDERS -->
<div class="card-header" style="border-top: 2px solid red;">
  <h3 class="card-title" style="margin-left: 10px;padding-top: 10px;text-transform: uppercase;font-weight: bold;">
    <?php echo $panel_title; ?>
  </h3>

  <div class="card-tools">
    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
    </button>
    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
    </button>
  </div>
</div>
<div class="card-body table-responsive p-0">
  
  <table class="table m-0 table-striped">
    <tr>
      <th><?php echo get_msg('no'); ?></th>
      <th><?php echo get_msg('name_label'); ?></th>
      <th><?php echo get_msg('trans_billing_address'); ?></th>
      <th><?php echo get_msg('trans_delivery_address'); ?></th>
       <th><?php echo get_msg('trans_status'); ?></th>
      <th><?php echo get_msg('trans_date_label'); ?></th>
    </tr>
    
    <?php $count = $this->uri->segment(4) or $count = 0; ?>
    <?php if ( ! empty( $data )): ?>
      <?php foreach($data as $d): ?>
          <tr>
            <td><?php echo ++$count; ?></td>
            <td><?php echo $d->contact_name; ?></td>
            <td><?php echo $d->billing_address; ?></td>
            <td><?php echo $d->delivery_address; ?></td>
            <td>
              <?php if ($d->trans_status_id == 1) { ?>
                <span class="badge badge-danger">
                  <?php echo $this->Transactionstatus->get_one( $d->trans_status_id )->title; ?>
                </span>
              <?php } elseif ($d->trans_status_id == 2) { ?>
                <span class="badge badge-info">
                  <?php echo $this->Transactionstatus->get_one( $d->trans_status_id )->title; ?>
                </span>
              <?php } elseif ($d->trans_status_id == 3) { ?>
                <span class="badge badge-success">
                  <?php echo $this->Transactionstatus->get_one( $d->trans_status_id )->title; ?>
                </span>
              <?php } else { ?>
                <span class="badge badge-primary">
                  <?php echo $this->Transactionstatus->get_one( $d->trans_status_id )->title; ?>
                </span>
              <?php } ?>
            </td>
            <td><?php echo $d->added_date; ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
   
  </table>
</div>
  <!-- /.table-responsive -->

<div class="card-footer text-center">
  <a href="<?php echo site_url('admin/transactions'); ?>"><?php echo get_msg('view_all_label'); ?></a>
</div>
<!-- /.card-footer -->
           