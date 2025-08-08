<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable({
            searching: false,
            order: [[0, 'desc']],
        });
        getData()
    });

    $('.btn-get-data').click(function() {
        getData()
    })

    function getData(){
        
        $('#loading-filter').show();
        var dataTableObj = $('#table').DataTable();
        var filter_kode = $('#filter-kode').val()
        var filter_nama = $('#filter-nama').val()
        
        dataTableObj.clear().draw();

        $.ajax({
            url: '{{url("kategori/search")}}',
            dataType: 'json',
            tryCount: 0,
            retryLimit: 3,
            data: 'kode=' + filter_kode + '&nama=' + filter_nama,
            success: function(results) {
                var data = results.data

                $.each(data, function(index, item) {
                    array_temp = [];
                    
                    var viewBtn = `<a href="{{url('kategori/view/')}}/` + item.id + `" class="btn btn-primary btn-sm me-1" title="Lihat Detail"><i class="fas fa-eye"></i> View</a>`;
                    var editBtn = `<a href="{{url('kategori/form/edit/')}}/` + item.id + `" class="btn btn-warning btn-sm me-1" title="Edit Kategori"><i class="fas fa-edit"></i> Edit</a>`;
                    var deleteBtn = `<button type="button" class="btn btn-danger btn-sm" onclick="deleteKategori(` + item.id + `)" title="Hapus Kategori"><i class="fas fa-trash"></i> Delete</button>`;
                    
                    var actions = `<div class="btn-group" role="group">` + viewBtn + editBtn + deleteBtn + `</div>`;

                    // Use sequential numbering instead of database ID
                    var sequentialNumber = index + 1;
                    array_temp.push(sequentialNumber);
                    array_temp.push(item.kode);
                    array_temp.push(item.nama);
                    array_temp.push(actions);

                    dataTableObj.row.add(array_temp).draw(true);
                });
                $('#loading-filter').hide();
            },
            error: function(xhr, textStatus, errorThrown) {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    $.ajax(this);
                    return;
                }
                alert('Terjadi kesalahan server, tidak dapat mengambil data')
                $('#loading-filter').hide();

                return;
            }
        })
    }

    function deleteKategori(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            console.log('Deleting kategori with ID:', id);
            
            // Get CSRF token
            var token = $('meta[name="csrf-token"]').attr('content');
            if (!token) {
                token = '{{ csrf_token() }}';
            }
            
            console.log('Using CSRF token:', token);
            
            // Use AJAX for better error handling
            $.ajax({
                url: '{{url("kategori/delete")}}/' + id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                data: JSON.stringify({
                    '_token': token
                }),
                success: function(response) {
                    console.log('Delete successful:', response);
                    if (response.success) {
                        alert(response.message || 'Kategori berhasil dihapus!');
                        // Refresh the table
                        getData();
                    } else {
                        alert(response.message || 'Gagal menghapus kategori');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete failed:', xhr);
                    console.error('Status:', status);
                    console.error('Error:', error);
                    
                    var errorMessage = 'Gagal menghapus kategori';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        errorMessage += ': ' + xhr.responseText;
                    }
                    
                    alert(errorMessage);
                    
                    // Fallback: try form submission
                    console.log('Trying fallback form submission...');
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{url("kategori/delete")}}/' + id;
                    
                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = token;
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }
</script>
