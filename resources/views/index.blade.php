<form action="/api/import" method="POST" enctype="multipart/form-data">
	@csrf
	<input type="file" name="importexcel">
	<input type="hidden" name="id_bumn_pembina_enc" value="TLKM">
	<input type="hidden" name="tahun_laporan_enc" value="2019">
	<input type="hidden" name="id_periode_enc" value="2">
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