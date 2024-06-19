@extends('layouts.main')

@section('main-content')
<div class="container">
    <div style="height: 40px"></div>
                <div class="row justify-content-center mt-5">
                    <div class="col-md-4 text-center">
                                    
                </div>
                <section class="section profile">
                    <div class="row">
                      <div class="col-xl-4">
              
                        <div class="card">
                          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              
                            <img src="{{ asset('img/RoadWatch.png') }}" style="width: 80%;">
                          </div>
                        </div>
                        
              
                        <div class="card mt-4">
                          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            <p>Dibuat oleh:</p>
              
                            <img src="https://avatars.githubusercontent.com/u/93889874?v=4" alt="Profile Image" class="profile-img-about">
                            <h3>Nanda Arya Adyatma</h3>
                            <h6>2105551035 - Universitas Udayana</h6>
                            <div class="social-links mt-2">
                                <h2>
                                    <a href="https://github.com/nandaadyatma" class="linkedin"><i class="bi bi-github"></i></a>
                                </h2>
                            </div>
                          </div>
                        </div>
              
                      </div>
              
                      <div class="col-xl-8">
              
                        <div class="card">
                          <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            
                            <div class="tab-content pt-2">
              
                              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                  <img src="https://images.unsplash.com/photo-1541465859444-326ef2fb999b?q=80&w=1931&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="banner" style="width: 100%; height: 250px; object-fit: cover; border-radius: 5px">
                                  <h5 class="card-title" style="margin-top: 20px">Tentang Roadwatch</h5>
                                <p class="medium" style="margin-top: 10px">
                                    Roadwatch merupakan platform layanan untuk berbagi informasi seputar kondisi jalan yang ada di Bali.
                                    Kamu dapat dengan bebas menambahkan informasi baru untuk dicatat di Roadwatch. Roadwatch menyediakan
                                    beberapa fitur seperti Tambah data ruas jalan baru, lihat ruas jalan pada peta, melihat daftar ruas jalan,
                                    edit data ruas jalan, hapus data ruas jalan, dan masih banyak lagi.
                                </p>
              
                                <h5 class="card-title">Profil Pembuat</h5>
              
                                <div class="row">
                                  <div class="col-lg-3 col-md-4 label ">Nama</div>
                                  <div class="col-lg-9 col-md-8">Putu Nanda Arya Adyatma</div>
                                </div>
              
                                <div class="row">
                                  <div class="col-lg-3 col-md-4 label">NIM</div>
                                  <div class="col-lg-9 col-md-8">2105551035</div>
                                </div>
              
                                <div class="row">
                                  <div class="col-lg-3 col-md-4 label">Pekerjaan</div>
                                  <div class="col-lg-9 col-md-8">Mahasiswa</div>
                                </div>
              
                                <div class="row">
                                  <div class="col-lg-3 col-md-4 label">Negara Tinggal</div>
                                  <div class="col-lg-9 col-md-8">Indonesia</div>
                                </div>
              
                                <div class="row">
                                  <div class="col-lg-3 col-md-4 label">Email</div>
                                  <div class="col-lg-9 col-md-8">aryaadyatma@unud.ac.id</div>
                                </div>
              
                              </div>
              
              
                            </div>
              
                          </div>
                        </div>
              
                      </div>
                    </div>
                  </section>
      
                
  
       
    
</div>
    
@endsection