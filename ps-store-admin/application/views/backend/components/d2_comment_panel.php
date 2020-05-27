<!-- Comment -->
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

<div class="card-body b-t collapse show">
    <table class="table v-middle no-border">
        <tbody>
            <?php $count = $this->uri->segment(4) or $count = 0; ?>
                <?php if ( ! empty( $data )): ?>
                  <?php foreach($data as $d): ?>

                        <tr>
                            <td>
                                <?php $logged_in_user = $this->ps_auth->get_user_info(); ?>
                                <img class="img-circle img-sm" src="<?php echo img_url( 'thumbnail/'. $logged_in_user->user_profile_photo ); ?>" class="user-image" alt="User Image">
                                 <span style="padding-left: 10px;font-weight: bold;">
                                    <?php echo $this->User->get_one($d->user_id)->user_name; ?><br>
                                </span>
                                <p style="padding-left: 40px;"><?php 
                                $comment = strip_tags($d->header_comment);

                                if (strlen($comment) > 40) {
                        
                                $stringCut = substr($comment, 0, 40);
                
                                $comment = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
                                }

                            echo $comment; ?>
                                    
                                </p>
                            </td>
                            <?php 
                                $detail_count = 0;
                                $conds['header_id'] = $d->id;
                                $detail_count = $this->Commentdetail->count_all_by( $conds );
                                if ( !$detail_count ) {
                            ?>
                                <td align="right"><i class="fa fa-dot-circle-o m-r-5 text-danger"></i></td>
                            <?php } else { ?>
                                <td align="right"><i class="fa fa-check-circle m-r-5 text-info"></i></td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
 
        </tbody>
    </table>
</div>

<div class="card-footer text-center">
    <a href="<?php echo site_url('/admin/comments')?>" class="uppercase">View All Comments</a>
</div>
<!-- /.card-footer -->
