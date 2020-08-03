<?php
	$data['tittle'] = "Pemeliharaan Aset";
	$this->load->view('template/head', $data);
?>
<body>
    <div id="wrapper">
        <?php $this->load->view('template/navbar'); ?>
        <!--/. NAV TOP  -->
        <?php $this->load->view('template/menu'); ?>
        <!-- /. NAV SIDE  -->

		<div id="page-wrapper">
            <div class="header"> 
                <h1 class="page-header">
                    Pemeliharaan Aset
                </h1>
                <?= $this->session->flashdata('pesan'); ?>
                <ol class="breadcrumb">
                    <li><a href="#"><?php $str = $this->session->userdata('nama_pegawai');
                    echo wordwrap($str, 15, "<br>\n"); ?></a></li>
                    <li><a href="<?=base_url()?>Aset/home">Home</a></li>
                    <li class="active">Pemeliharaan Aset</li>
                </ol> 
            </div>
            
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pemeliharaan Aset Internal</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="internal">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjam</th>
                                                <th>Kode Aset</th>
                                                <th>Nama Aset</th>
                                                <th>Merek/Type</th>
                                                <th>Kondisi</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dt_internal">
                                        </tbody>
                                    </table>
                                </div>
                            </div>						
                        </div>   
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 style="font-weight:bold;">Pemeliharaan Aset External</h3>
                                <hr align="right" color="black">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="external">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Peminjam</th>
                                                <th>Kode Aset</th>
                                                <th>Nama Aset</th>
                                                <th>Merek/Type</th>
                                                <th>Kondisi</th>
                                                <th>Umur Ekonomis</th>
                                                <th>Nilai Sisa</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dt_external">
                                        </tbody>
                                    </table>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
				<?php $this->load->view('template/copyright') ?>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php $this->load->view('template/script') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            tampil_internal();
            tampil_external();

            $('#internal').dataTable();
            $('#external').dataTable();
        })

        function tampil_internal() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Pemeliharaan_aset/get_pelihara_aset_internal') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        if (c[h].stts_approval == 4) {
                            text = "Selesai";
                            stts = "success";
                            icon = "check";
                        } else {
                            text = "Proses";
                            stts = "info";
                            icon = "cog";
                        }

                        if (c[h].kondisi_brg == 2) {
                            kondisi_brg = "Rusak Ringan";
                        } else if(c[h].kondisi_brg == 3){
                            kondisi_brg = "Rusak Berat";
                        } else {
                            kondisi_brg = "Baik";
                        }

                        pgdn +=
                            '<tr>' + 
                                '<td>' + (h + 1) + '</td>' +
                                '<td>' + c[h].kd_brg + '</td>' +
                                '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                                '<td>' + c[h].nm_brg + '</td>' +
                                '<td>' + c[h].merk_type + '</td>' +
                                '<td>' + kondisi_brg + '</td>' +
                                '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + ribuan + '</td>' +
                                '<td style="text-align: center;"><button type="button" disabled title="Selesai" class="btn btn-sm btn-'+stts+'"><i class="fa fa-'+icon+'"></i> '+text+'</button></td>' +
                            '</tr>';
                    }
                    $('#dt_internal').html(pgdn);
                    
                }
            });
        }

        function tampil_external() {
            $.ajax({
                type: "GET",
                url: "<?= base_url('Pemeliharaan_aset/get_pelihara_aset_external') ?>",
                async: false,
                dataType: "JSON",
                success: function(c) {
                    var pgdn = "";
                    for (h = 0; h < c.length; h++) {
                        var bilangan = c[h].nli_sisa;
                            
                        var	reverse = bilangan.toString().split('').reverse().join(''),
                            ribuan 	= reverse.match(/\d{1,3}/g);
                            ribuan	= ribuan.join('.').split('').reverse().join('');

                        if (c[h].stts_approval == 5) {
                            text = "Selesai";
                            stts = "success";
                            icon = "check";
                        } else {
                            text = "Proses";
                            stts = "info";
                            icon = "cog";
                        }

                        if (c[h].kondisi_brg == 2) {
                            kondisi_brg = "Rusak Ringan";
                        } else if(c[h].kondisi_brg == 3){
                            kondisi_brg = "Rusak Berat";
                        } else {
                            kondisi_brg = "Baik";
                        }

                        pgdn +=
                            '<tr>' + 
                                '<td>' + (h + 1) + '</td>' +
                                '<td>' + c[h].kd_brg + '</td>' +
                                '<td style="text-align: center;">' + c[h].no_reg + '</td>' +
                                '<td>' + c[h].nm_brg + '</td>' +
                                '<td>' + c[h].merk_type + '</td>' +
                                '<td>' + kondisi_brg + '</td>' +
                                '<td style="text-align: right;">' + c[h].umr_ekonomis + '</td>' +
                                '<td style="text-align: right;">' + ribuan + '</td>' +
                                '<td style="text-align: right;"><button type="button" disabled title="Selesai" class="btn btn-sm btn-'+stts+'"><i class="fa fa-'+icon+'"></i> '+text+'</button></td>' +
                            '</tr>';
                    }
                    $('#dt_external').html(pgdn);
                }
            });
        }
    </script>

</body>

</html>