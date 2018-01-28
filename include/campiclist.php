<?php require 'session.php' ?>
<?php if(isset($isloggedin) && $isloggedin): ?>
    <!-- gallery navigation -->

    <div id="nav-form">
        <div id="row">
            <div id="col" class="form-group">
                <div class="btn-group btn-group-toggle">
                    <button type="button" id="goToFirst" class="btn btn-outline-dark">&nbsp;&laquo;&nbsp;</button>
                    <button type="button" id="goToPrev" class="btn btn-outline-dark">&nbsp;&lsaquo;&nbsp;</button>
                    <button type="button" id="goToNext" class="btn btn-outline-dark">&nbsp;&rsaquo;&nbsp;</button>
                    <button type="button" id="goToLast" class="btn btn-outline-dark">&nbsp;&raquo;&nbsp;</button>
                </div>
            </div> <!-- col -->
            <div id="col" class="form-group">
                <!--
                <form class="form-inline">
                -->
                <form>
                    <label>Images per page: </label>&nbsp;&nbsp;
                    <!--
                    <select class="form-control" style="width:70px; text-align:center" id="picsperpage">
                    -->
                    <select id="picsperpage">
                        <option selected>12</option>
                        <option>24</option>
                        <option>36</option>
                        <option>48</option>
                        <option>60</option>
                    </select>
                </form>
            </div> <!-- col -->
            <div id="col" class="form-group">
                <label>Page: <span id="curpage">1</span>/<span id="totalpages">?</span></label>
                &nbsp;&nbsp;
                <label>Total images: <span id="totalpictures">?</span></label>
                &nbsp;&nbsp;
                <label><span id="spinner"></span></label>
            </div> <!-- col -->
        </div> <!-- row -->
    </div>
    <!-- gallery container -->
    <div class="row" id="piclistgallery">
    </div>
    <script>
        attachEventsToCamPicList();
        goToPage('first');
    </script>
<?php else: ?>
    <?php
        //not authenticated, redirect to home page
        header('Location: ../');
    ?>
<?php endif ?>
