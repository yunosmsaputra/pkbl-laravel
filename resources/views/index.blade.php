<form action="/import" method="POST" enctype="multipart/form-data">
	@csrf
	<input type="file" name="file">
	<input type="submit">
</form>
<a href="/download/AABR/2019/1" onclick="downloasd()">download excel</a>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function downloasd(){
		$.ajax({
	        type:'POST',
	        url: '/downloadpost',
	        data: {
	        	"_token": "{{ csrf_token() }}",
	            id_bumn_pembina: 'AABR',
	            tahun_laporan: '2019',
	            id_periode: '1',
	        },
	        dataType: 'json',
	        success : function(data){
	            // $(loader).dialog('close');
	            // $(loader).dialog('destroy').remove();
	            var a = $("<a>");
	            a.attr("href", data);
	            $("#downloadexcel").append(a);
	            a.attr("download", "asdads.xls");
	            a[0].click();
	            // a.remove();
	        }
	    });
	}
</script>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-green-haze">
					<i class="icon-setting font-green-haze"></i>
					<span class="caption-subject bold uppercase">Hasil Validasi</span>
				</div>
				<div class="actions">
					<a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""></a>
				</div>
			</div>
			<div class="portlet-body table-responsive">
				<table class="table table-hover table-striped table-bordered" style="white-space: nowrap;">
					<thead>
						<tr>
							<th width="80px">Kode Provinsi</th>
							<th width="80px">Kode Kab/Kota</th>
							<th width="150px">Nama</th>
							<th width="130px">No KTP</th>
							<th width="250px">Alamat</th>
							<th width="80px">Jenis Kelamin</th>
							<th width="80px">Tanggal Lahir</th>
							<th width="100px"><div align="center">Jumlah Pinjaman (Rp.)</div></th>
							<th width="100px"><div align="center">Posisi Pinjaman (Rp.)</div></th>
							<th width="80px">Tanggal Perjanjian</th>
							<th width="80px">Jumlah Tenaga Kerja</th>
							<th width="80px">Kode Status</th>
							<th width="100px"><div align="center">Posisi Aset (Rp.)</div></th>
							<th width="100px"><div align="center">Omset (Rp.)</div></th>
							<th width="80px">Pinjaman Ke-</th>
							<th width="100px">Kode Jenis Usaha</th>
							<th width="100px">Jenis Produk</th>
							<th width="100px">Pinjaman Khusus</th>
							<th width="100px">Kode Sektor Usaha</th>
							<th width="100px">Kode Kategori Usaha</th>
							<th width="80px">Unggulan</th>
							<th width="250px">Keterangan</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>