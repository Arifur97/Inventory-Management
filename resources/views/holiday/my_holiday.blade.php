@extends('layout.main')
@section('content')
<section>

	 <!--- header section  --->

	 <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.My Holiday')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- header section  --->

    <div class="container-fluid">
		
		<div class="table-responsive mt-3">
			<table class="table table-bordered" style="width: 100%; border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
				<thead>
					<tr>
						<th><a href="{{url('holidays/my-holiday/'.$prev_year.'/'.$prev_month)}}"><i class="fa fa-arrow-left"></i> {{trans('file.Previous')}}</a></th>
						<th colspan="5" class="text-center">{{date("F", strtotime($year.'-'.$month.'-01')).' ' .$year}}</th>
						<th><a href="{{url('holidays/my-holiday/'.$next_year.'/'.$next_month)}}">{{trans('file.Next')}} <i class="fa fa-arrow-right"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>Sunday</strong></td>
						<td><strong>Monday</strong></td>
						<td><strong>Tuesday</strong></td>
						<td><strong>Wednesday</strong></td>
						<td><strong>Thrusday</strong></td>
						<td><strong>Friday</strong></td>
						<td><strong>Saturday</strong></td>
					</tr>
					<?php
						$i = 1;
						$flag = 0;
						while ($i <= $number_of_day) {
							echo '<tr>';
							for($j=1 ; $j<=7 ; $j++){
								if($i > $number_of_day)
									break;

								if($flag){
									if(($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d')) && !$holidays[$i]) {
										echo '<td><p style="color:red"><strong>'.$i.'</strong></p>';
									}
									elseif($holidays[$i]){
										echo '<td><p style="color:#006600"><strong>'.$i.'</strong></p><span style="width: 112px; height: 20px; border-top: 7px solid transparent ; border-bottom: 35px solid transparent ; color:#f87b28; font-size:12px;" class="text-center">'.$holidays[$i].'</span><br>';
									}
									else
										echo '<td><p><strong>'.$i.'</strong></p>';
									echo '</td>';
									$i++;
								}
								elseif($j == $start_day){
									if(($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d')) && !$holidays[$i]) {
										echo '<td><p style="color:red"><strong>'.$i.'</strong></p>';
									}
									elseif($holidays[$i]){
										echo '<td><p style="color:#006600"><strong>'.$i.'</strong></p><span style="width: 112px; height: 20px; border-top: 7px solid transparent ; border-bottom: 35px solid transparent ; color:#f87b28; font-size:12px;" class="text-center">'.$holidays[$i].'</span><br>';
									}
									else
										echo '<td><p><strong>'.$i.'</strong></p>';
									echo '</td>';
									$flag = 1;
									$i++;
									continue;
								}
								else {
									echo '<td></td>';
								}
							}
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>

<script type="text/javascript">


</script>
@endsection
