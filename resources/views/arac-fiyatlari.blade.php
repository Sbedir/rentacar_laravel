@inject('genelService', 'App\Services\GenelService')
@extends('layout')
@section('icerik')
<div class="contents">
@if (Session::has('success'))
    <div class="alert alert-success" >
        {{ Session::get('success') }}
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif


    <div class="atbd-page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Araç Fiyatları</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                        
                            <!-- <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Dışa Aktar(Pdf-Excel)
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <span class="dropdown-item">Dışa Aktar</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <i class="la la-file-pdf"></i> PDF</a>
                                    <a href="#" class="dropdown-item">
                                        <i class="la la-file-excel"></i> Excel (XLSX)</a>
                                
                                </div>
                            </div> -->
                        
                            <div class="action-btn">
                                <a href="#" onClick="ekleModal()" class="btn btn-sm btn-primary btn-add">
                                    <i class="la la-plus"></i> Araç Fiyatı Ekle</a>
                            </div>
                        </div>
                    </div>

                </div>

                
                <div class="col-lg-12">
                    <div class="card mb-25">
                    
                        <div class="card-body pt-0 pb-0">
                            <div class="drag-drop-wrap">
                                <div class="drag-drop table-responsive-lg bg-white w-100 mb-30">
                                    <table id='datatable' class="table mb-0 table-basic table-responsive">
                                        <thead>
                                            <tr>
                                                
                                                <th>İşlem</th> 
                                                <th>Araç</th>
                                                <th>Kira Başlama Günü</th>
                                                <th>Kira Bitiş Günü</th>
                                                <th>Fiyat</th>
                                                <th>Fiyat Para Birimi</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($aracfiyatVerileri as $aracfiyat)
                                            <tr >
                                                <td>
                                                <div class="table-actions">
                                                        <a href="#" onClick='guncelleModal({{ json_encode($aracfiyat) }})'>
                                                            <span data-feather="edit"></span>
                                                        </a>
                                                        <a href="#" onClick='silModal({{ json_encode($aracfiyat) }})'>
                                                            <span data-feather="trash-2"></span>
                                                        </a>
                                                    
                                                    </div>
                                                </td>
                                              
                                                <td>{{$aracfiyat->arac_adi}}</td>
                                                <td>{{$aracfiyat->gun_baslangic}}</td>
                                                <td>{{$aracfiyat->gun_bitis}}</td>
                                                <td>{{$aracfiyat->fiyat}}</td>
                                                <td>{{$aracfiyat->para_birim}}</td>
                                               
                                            
                                            </tr>
                                            @endforeach
                                       

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ends: .card -->

                </div>
                <!-- ends: .col-lg-6 -->
            </div>
        </div>
    </div>


</div>

<!--modall-->
<div class="modal-basic modal fade show" id="ekleGüncelleModal" tabindex="-1" role="dialog" aria-hidden="true">


    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-bg-white ">
            <div id='modal-header-back' class="modal-header  bg-success">



                <h6 class="modal-title">Araç Fiyat Ekleme</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span data-feather="x"></span></button>
            </div>
            <form method="POST" action="{{ route('arac-fiyatlari.create.update') }}" enctype="multipart/form-data">
                @csrf <!-- Cross-Site Request Forgery (CSRF) koruması -->
                <input name="a_fiyat_id" id='a_fiyat_id'  type="hidden" class="form-control form-control-default">
            <div class="modal-body">
                <div class="row">
               
                    <div class="col-md-4 mt-2">
                        <div class="form-group mb-0">
                            
                            <label for="" class="form-group mb-0"><b>Araç</b></label>
                            <div class="atbd-select-list d-flex">
                                <div class="atbd-select " style="width: 100%;">
                                <select name="arac_id" id='arac_id'  class="form-control" style="width: 100%;">
                                        <option value="">Seçiniz</option>  
                                        @foreach ($genelService->arac() as $arac)
                                            <option value="{{$arac->a_id}}">{{$arac->aracadi}}</option>
                                        @endforeach 
                                            
                                        
                                        </select>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-group mb-0">
                            <div class="input-container icon-left position-relative">
                                <label for=""  class="form-group mb-0"><b>Kira Gün Başlama</b></label>
                                <input name="gun_baslangic" id="gun_baslangic" min="0" type="number" class="form-control form-control-default" placeholder="Başlama gün sayısını ekleyiniz.">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-group mb-0">
                            <div class="input-container icon-left position-relative">
                                <label for=""  class="form-group mb-0"><b>Kira Gün Bitiş</b></label>
                                <input name="gun_bitis" id="gun_bitis" min="0" type="number" class="form-control form-control-default" placeholder="Bitiş gün sayısını ekleyiniz.">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-group mb-0">
                            <div class="input-container icon-left position-relative">
                                <label for=""  class="form-group mb-0"><b>Kira Fiyatı</b></label>
                                <input name="fiyat" id="fiyat" min="0" type="number" class="form-control form-control-default" placeholder="Kira fiyatını ekleyiniz.">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 mt-2">
                        <div class="form-group mb-0">
                            
                            <label for="" class="form-group mb-0"><b>Para Birimi</b></label>
                            <div class="atbd-select-list d-flex">
                                <div class="atbd-select " style="width: 100%;">
                                <select name="para_birim_id" id="para_birim_id" class="form-control " style="width: 100%;">
                                    <option value="">Seçiniz</option>  
                                        @foreach ($genelService->paraBirimi() as $parabirim)
                                            <option value="{{$parabirim->para_birim_id}}">{{$parabirim->para_name}}</option>
                                        @endforeach 
                                            
                                      
                                    </select>

                                </div>

                            </div>
                        </div>
                    </div>





                </div>
            </div>
           
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Kaydet</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kapat</button>
            </div>
            </form>
        </div>
    </div>


</div>
<div class="modal-basic modal fade show" id="silModal" tabindex="-1" role="dialog" aria-hidden="true">


    <div class="modal-dialog" role="document">
        <div class="modal-content modal-bg-white ">
            <div class="modal-header bg-danger">



                <h6 class="modal-title">Araç Fiyatı Silme</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span data-feather="x"></span></button>
            </div>
            <form method="POST" action="{{ route('fiyat.delete') }}" enctype="multipart/form-data">
                @csrf <!-- Cross-Site Request Forgery (CSRF) koruması -->
              
                <input name="sil_id" id='sil_id'  type="hidden" class="form-control form-control-default">
            <div class="modal-body">
                <div class="row">
                   Silmek istediğinize emin misiniz?

                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">Sil</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kapat</button>
            </div>
             </form>

        </div>
    </div>


</div>
<script>
    
    function ekleModal()
    {
        
         $( "#modal-header-back" ).removeClass( "bg-warning" ).addClass("bg-success");
        $('#modalTitle').html('Araç Fiyat Ekleme'); 
        $('#a_fiyat_id').val("");
        $('#para_birim_id').val("");
        $('#fiyat').val("");
        $('#arac_id').val("");
        $('#gun_baslangic').val("");
        $('#gun_bitis').val("");
        $('#ekleGüncelleModal').modal();
    }
    function guncelleModal(aracfiyat)
    {
        console.log(aracfiyat)
        $( "#modal-header-back" ).removeClass( "bg-success" ).addClass( "bg-warning" );
        $('#modalTitle').html('Araç Fiyat Güncelleme');
        $('#a_fiyat_id').val(aracfiyat.a_fiyat_id);
        $('#arac_id').val(aracfiyat.arac_id);
        $('#gun_baslangic').val(aracfiyat.gun_baslangic);
        $('#gun_bitis').val(aracfiyat.gun_bitis);
        $('#para_birim_id').val(aracfiyat.para_birim_id);
        $('#fiyat').val(aracfiyat.fiyat);
    
 
       
        $('#ekleGüncelleModal').modal();
    }
    function silModal(aracfiyat)
    {
        $('#sil_id').val(aracfiyat.a_fiyat_id);
        console.log(aracfiyat);
        $('#silModal').modal();
    }

   


    

 

    
</script>
@endsection