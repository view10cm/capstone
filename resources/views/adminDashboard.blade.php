@extends('base')

@section('content')
    @include('admin.adminSidebar')
    <div class="container" style="margin-left:260px; padding: 40px 0;">
        <div style="max-width:1100px; margin:auto;">
            <!-- Inventory Header -->
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <h2 style="margin:0; font-weight:600;">Inventory</h2>
                    <span style="color:#888;">Manage your inventory items</span>
                </div>
                <div style="flex:1; display:flex; justify-content:center;">
                    <input type="text" placeholder="Search..."
                        style="width:350px; padding:10px 40px 10px 40px; border-radius:25px; border:1px solid #ddd; background:#f7f7f7 url('data:image/svg+xml;utf8,<svg fill=\'%23999\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'20\' height=\'20\'><path d=\'M21 20l-5.197-5.197A7.92 7.92 0 0018 10a8 8 0 10-8 8 7.92 7.92 0 004.803-1.803L20 21zM4 10a6 6 0 1112 0 6 6 0 01-12 0z\'/></svg>') no-repeat 12px center;">
                </div>
            </div>

            <!-- Products Table Card -->
            <div style="background:#fff; border-radius:16px; box-shadow:0 2px 8px #0001; margin-top:32px; padding:32px;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span style="font-size:1.5rem; color:#ff9100;">
                            <svg width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="4" y="7" width="20" height="14" rx="3" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                                <rect x="8" y="3" width="12" height="4" rx="2" stroke="#ff9100"
                                    stroke-width="2" fill="none" />
                            </svg>
                        </span>
                        <h3 style="margin:0; font-weight:600;">Products</h3>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <input type="text" placeholder="Search"
                            style="padding:7px 14px; border-radius:8px; border:1px solid #ddd;">
                        <button
                            style="background:#fff; border:1px solid #ff9100; color:#ff9100; border-radius:8px; padding:7px 18px; font-weight:500;">Export
                            ▼</button>
                        <button
                            style="background:#ff9100; color:#fff; border:none; border-radius:8px; padding:7px 18px; font-weight:500; display:flex; align-items:center; gap:6px;">
                            <span style="font-size:1.2em;">+</span> Add Product
                        </button>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:separate; border-spacing:0 8px;">
                        <thead>
                            <tr style="background:#f7f7f7;">
                                <th style="padding:10px 8px;"><input type="checkbox"></th>
                                <th style="padding:10px 8px; text-align:left;">Item ID</th>
                                <th style="padding:10px 8px; text-align:left;">Product Name <span
                                        style="font-size:0.9em; color:#bbb;">⇅</span></th>
                                <th style="padding:10px 8px; text-align:left;">Category <span
                                        style="font-size:0.9em; color:#bbb;">⇅</span></th>
                                <th style="padding:10px 8px; text-align:left;">Quantity</th>
                                <th style="padding:10px 8px; text-align:left;">Availability</th>
                                <th style="padding:10px 8px; text-align:left;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00001</td>
                                <td style="padding:10px 8px;">Beef</td>
                                <td style="padding:10px 8px;">Meat</td>
                                <td style="padding:10px 8px;">15 kg</td>
                                <td style="padding:10px 8px; color:green;">In Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00002</td>
                                <td style="padding:10px 8px;">Garlic</td>
                                <td style="padding:10px 8px;">Vegetables</td>
                                <td style="padding:10px 8px;">5 pcs</td>
                                <td style="padding:10px 8px; color:#ff9100;">Low Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00003</td>
                                <td style="padding:10px 8px;">Onion</td>
                                <td style="padding:10px 8px;">Vegetables</td>
                                <td style="padding:10px 8px;">15 pcs</td>
                                <td style="padding:10px 8px; color:green;">In Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00004</td>
                                <td style="padding:10px 8px;">Okra</td>
                                <td style="padding:10px 8px;">Vegetables</td>
                                <td style="padding:10px 8px;">0 pcs</td>
                                <td style="padding:10px 8px; color:#e53935;">Out of Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00005</td>
                                <td style="padding:10px 8px;">Oxtail</td>
                                <td style="padding:10px 8px;">Meat</td>
                                <td style="padding:10px 8px;">1 kg</td>
                                <td style="padding:10px 8px; color:#ff9100;">Low Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00006</td>
                                <td style="padding:10px 8px;">Eggplant</td>
                                <td style="padding:10px 8px;">Vegetables</td>
                                <td style="padding:10px 8px;">5 pcs</td>
                                <td style="padding:10px 8px; color:#ff9100;">Low Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00007</td>
                                <td style="padding:10px 8px;">Espresso Shot</td>
                                <td style="padding:10px 8px;">Coffee Base</td>
                                <td style="padding:10px 8px;">30 shots</td>
                                <td style="padding:10px 8px; color:green;">In Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                            <tr style="background:#fff;">
                                <td style="padding:10px 8px;"><input type="checkbox"></td>
                                <td style="padding:10px 8px;">CA00008</td>
                                <td style="padding:10px 8px;">Vanilla Syrup</td>
                                <td style="padding:10px 8px;">Syrup/Flavoring</td>
                                <td style="padding:10px 8px;">5-10 pumps</td>
                                <td style="padding:10px 8px; color:#ff9100;">Low Stock</td>
                                <td style="padding:10px 8px;">
                                    <a href="#"><span style="font-size:1.1em;">✏️</span></a>
                                    <a href="#"><span style="font-size:1.1em; margin-left:10px;">🗑️</span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div style="display:flex; align-items:center; justify-content:space-between; margin-top:24px;">
                    <button
                        style="background:#fff; border:1px solid #ccc; border-radius:6px; padding:7px 18px;">Previous</button>
                    <span style="color:#888;">Page 1 of <b>10</b></span>
                    <button
                        style="background:#fff; border:1px solid #ccc; border-radius:6px; padding:7px 18px;">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection
