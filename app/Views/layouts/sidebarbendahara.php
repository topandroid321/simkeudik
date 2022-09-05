 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
         <div class="sidebar-brand-icon rotate-n-15">

         </div>
         <div class="sidebar-brand-text mx-3">SIMKEUDIK</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="index.html">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Interface
     </div>

     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Transaksi</span>
         </a>
         <div id="transaksi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="<?= base_url('/transaksimasuk') ?>">Transaksi Masuk</a>
                 <a class="collapse-item" href="<?= base_url('/kelolagajipengajar') ?>">Gaji Pengajar</a>
                 <a class="collapse-item" href="<?= base_url('/transaksikeluar') ?>">Transaksi Keluar</a>
             </div>
         </div>
     </li>



     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>Laporan</span>
         </a>
         <div id="laporan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="<?= base_url('/kelolalaporan') ?>">Laporan Pembayaran Diklat</a>
                 <a class="collapse-item" href="<?= base_url('/kelolalaporan') ?>/gajipengajar">Laporan Gaji Pengajar</a>
                 <a class="collapse-item" href="<?= base_url('/kelolalaporan') ?>/transaksikeluar">Laporan Transaksi Keluar</a>
                 <a class="collapse-item" href="cards.html">Laporan Saldo Akhir</a>
             </div>
         </div>
     </li>



     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->