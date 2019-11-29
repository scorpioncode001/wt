<?php require_once('joins/header.php'); ?>
<style>
  #user-upload-img{
    position: absolute;
    width:100%;
    height:100%;
    transition: all .3s linear;
    border-radius: 50%;
  }
  #user-upload-img > .img-txt{
      display:block;
      text-align:center;
      padding-top:40%;
  }
  #user-upload-img:hover{
    cursor: pointer;
    display:block;
    background:rgba(0,0,0,.5);
  }
  #img-upload{
    visibility: hidden;
    width:100%;
    height:100%;
  }
</style>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_POST['update_profile'])){
  //SETTING ALL THE VALUES TO A VARIABLE
  $ref_id = $ref_id;
  $fname = $db_init->escape(htmlentities($_POST ['fname']));
  $lname = $db_init->escape(htmlentities($_POST ['lname']));
  $email = $db_init->escape(htmlentities($_POST ['email']));
  $phone = $db_init->escape(htmlentities($_POST ['phone']));
  $country = $db_init->escape(htmlentities($_POST ['country']));
  $continent = $db_init->escape(htmlentities($_POST ['continent']));
  $fileName = $_FILES['file']['name'];


  //CHECKING IF EMAIL ALREADY REGISTERED
//   $confirm_email = User::confirm_email_users($email);
//   if($db_init->num_rows($confirm_email)>0){
//       //MAKE PUP UP
//       echo "<script> alert('Emal already exists!'); window.location='profile.php'; </script>";
//       die();
//   }
//   $confirm_email = User::confirm_email_admins($email);
//   if($db_init->num_rows($confirm_email)>0){
//       //MAKE PUP UP
//       echo "<script> alert('Emal already exists!'); window.location='profile.php'; </script>";
//       die();
//   }

  //CHECKING IF ALL FIELDS ARE FILLED OUT
//   if(empty($fname) ||  empty($lname) || empty($phone) || empty($email) || empty($country) || empty($continent)){
//       //MAKE PUP UP
//       echo "<script> alert('All fields must be filled!'); window.location='profile.php'; </script>";
//       die();
//   }else{
    
      //REGISTERS USER IF EVERY THING IS CORRECT
      //image validation
    if(!empty($fileName)){
        $fileType = $_FILES['file']['type'];
                    $fileExt = explode('.',$fileName);
                        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpeg','jpg','png');
        if (!in_array($fileActualExt, $allowed)){
            echo "<script> alert('File Type Not Allowed!'); window.location='profile.php'; </script>";
            die();
        }else{
            $picture = $db_init->escape(htmlentities($_FILES['file']['name']));
            $epicture = explode(".", $picture);
            $img_type = end($epicture);
            
            $current_year = date('Y'); $current_month = date('m'); $current_day = date('d'); $current_hour = date('H'); $current_min = date('i'); $current_sec = date('s');
            if(strlen($current_month)==1){
                $current_new_month = '0'.$current_month;
            }else{
                $current_new_month = $current_month;
            }

            $generate = uniqid('', true);
            $explode = explode('.', $generate);
            $array1 = $explode[0];
            $array2 = $explode[1];
            $img_initial = "IMG-".$current_year.$current_new_month.$current_day.$current_hour.$current_min.$current_sec."-";
            $main_picture = $img_initial.$array2.".".$img_type;
            $update = User::find_sql("UPDATE users SET image='$main_picture' WHERE id='$session->user_id'");
            if($update){
                move_uploaded_file($_FILES["file"]["tmp_name"],"../images/".$main_picture);
            }
        }
    }
      $register_user = User::update_user($fname, $lname, $email, $phone, $country, $continent, $session->user_id);

      if($register_user){
          require '../phpmailer/PHPMailerAutoload.php';

          $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
          $username= User::get_email_address(); 
            $pass2=User::get_email_password();
          $mail->Username = $username; 
            $mail->Password = $pass2;
      
          $mail->setFrom(User::get_email_address(), User::get_company_name());
          $mail->addAddress($email);
          
          $mail->Subject = 'ACCOUNT UPDATE';
          $mail ->AddEmbeddedImage('../images/wt_logo.png', 'logoimg');
          $mail->MsgHTML(User::account_update($email));
          if ($mail->send())
              echo "<script> alert('Account update successful!'); window.location='index.php'; </script>";
      //}
  }
}
?>
  <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="text-align:center">
                <h1>
                    User | Profile
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Profile</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-8 col-md-offset-2">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">User Profile</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="box box-widget widget-user">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-blue-active">
                                            <h3 class="widget-user-username"><?php echo $full_name; ?></h3>
                                        </div>
                                        <div class="widget-user-image">
                                          <label id="user-upload-img">
                                              <span class="img-txt">Change</span>
                                            <input name="file" type="file" id="img-upload">
                                          </label>
                                            <img class="img-circle" id="user-img"  src="<?php echo $picture ?>"
                                                alt="User Avatar" style="width:90px;height:90px">
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header"><?php echo $created_date_string; ?></h5>
                                                        <span class="description-text">Joined</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Active</h5>
                                                        <span class="description-text">Member</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4">
                                                    <div class="description-block">
                                                        <h5 class="description-header">User</h5>
                                                        <span class="description-text">Status</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fname"><i class="fa fa-user-circle"></i> First Name </label>
                                        <input type="text" class="form-control" placeholder="First Name" name='fname' value="<?php echo $fname; ?>">
                                    </div>
                                    <div class="form-group">
                                            <label for="fname"><i class="fa fa-user-circle"></i> Last Name </label>
                                            <input type="text" class="form-control" placeholder="Last Name" name='lname' value="<?php echo $lname; ?>">
                                        </div>
                                        <div class="form-group">
                                                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                                                <input type="email" class="form-control" placeholder="email" name='email' value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                    <label for="pnumber"><i class="fa fa-phone-square"></i> Phone Number</label>
                                                    <input type="text" class="form-control" placeholder="Phone" name='phone' value="<?php echo $phone; ?>">
                                                </div>
                                                    <div class="form-group">
                                                        <label for="continent"><i class="fa fa-map"></i> Continent </label>
                                                        <select name="continent" class="form-control">
                                                            <option value="<?php echo $continent; ?>"><?php echo $continent; ?></option>
                                                            <option value="Africa">Africa</option>
                                                            <option value="Antarctica">Antarctica</option>
                                                            <option value="Asia">Asia</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="North America">North America</option>
                                                            <option value="South America">South America</option>
                                                            <option value="Europe">Europe</option>
                                                        </select>
                                                    </div>
                                                <div class="form-group">
                                                        <label for="location"><i class="fa fa-globe"></i> Country</label>
                                                        <select name="country" class="form-control">
                                                            <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                                                            <option value="Afganistan">Afghanistan</option>
                                                            <option value="Albania">Albania</option>
                                                            <option value="Algeria">Algeria</option>
                                                            <option value="American Samoa">American Samoa</option>
                                                            <option value="Andorra">Andorra</option>
                                                            <option value="Angola">Angola</option>
                                                            <option value="Anguilla">Anguilla</option>
                                                            <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                                                            <option value="Argentina">Argentina</option>
                                                            <option value="Armenia">Armenia</option>
                                                            <option value="Aruba">Aruba</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="Austria">Austria</option>
                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                            <option value="Bahamas">Bahamas</option>
                                                            <option value="Bahrain">Bahrain</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Barbados">Barbados</option>
                                                            <option value="Belarus">Belarus</option>
                                                            <option value="Belgium">Belgium</option>
                                                            <option value="Belize">Belize</option>
                                                            <option value="Benin">Benin</option>
                                                            <option value="Bermuda">Bermuda</option>
                                                            <option value="Bhutan">Bhutan</option>
                                                            <option value="Bolivia">Bolivia</option>
                                                            <option value="Bonaire">Bonaire</option>
                                                            <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                                                            <option value="Botswana">Botswana</option>
                                                            <option value="Brazil">Brazil</option>
                                                            <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                            <option value="Brunei">Brunei</option>
                                                            <option value="Bulgaria">Bulgaria</option>
                                                            <option value="Burkina Faso">Burkina Faso</option>
                                                            <option value="Burundi">Burundi</option>
                                                            <option value="Cambodia">Cambodia</option>
                                                            <option value="Cameroon">Cameroon</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="Canary Islands">Canary Islands</option>
                                                            <option value="Cape Verde">Cape Verde</option>
                                                            <option value="Cayman Islands">Cayman Islands</option>
                                                            <option value="Central African Republic">Central African Republic</option>
                                                            <option value="Chad">Chad</option>
                                                            <option value="Channel Islands">Channel Islands</option>
                                                            <option value="Chile">Chile</option>
                                                            <option value="China">China</option>
                                                            <option value="Christmas Island">Christmas Island</option>
                                                            <option value="Cocos Island">Cocos Island</option>
                                                            <option value="Colombia">Colombia</option>
                                                            <option value="Comoros">Comoros</option>
                                                            <option value="Congo">Congo</option>
                                                            <option value="Cook Islands">Cook Islands</option>
                                                            <option value="Costa Rica">Costa Rica</option>
                                                            <option value="Cote DIvoire">Cote D'Ivoire</option>
                                                            <option value="Croatia">Croatia</option>
                                                            <option value="Cuba">Cuba</option>
                                                            <option value="Curaco">Curacao</option>
                                                            <option value="Cyprus">Cyprus</option>
                                                            <option value="Czech Republic">Czech Republic</option>
                                                            <option value="Denmark">Denmark</option>
                                                            <option value="Djibouti">Djibouti</option>
                                                            <option value="Dominica">Dominica</option>
                                                            <option value="Dominican Republic">Dominican Republic</option>
                                                            <option value="East Timor">East Timor</option>
                                                            <option value="Ecuador">Ecuador</option>
                                                            <option value="Egypt">Egypt</option>
                                                            <option value="El Salvador">El Salvador</option>
                                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                            <option value="Eritrea">Eritrea</option>
                                                            <option value="Estonia">Estonia</option>
                                                            <option value="Ethiopia">Ethiopia</option>
                                                            <option value="Falkland Islands">Falkland Islands</option>
                                                            <option value="Faroe Islands">Faroe Islands</option>
                                                            <option value="Fiji">Fiji</option>
                                                            <option value="Finland">Finland</option>
                                                            <option value="France">France</option>
                                                            <option value="French Guiana">French Guiana</option>
                                                            <option value="French Polynesia">French Polynesia</option>
                                                            <option value="French Southern Ter">French Southern Ter</option>
                                                            <option value="Gabon">Gabon</option>
                                                            <option value="Gambia">Gambia</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="Ghana">Ghana</option>
                                                            <option value="Gibraltar">Gibraltar</option>
                                                            <option value="Great Britain">Great Britain</option>
                                                            <option value="Greece">Greece</option>
                                                            <option value="Greenland">Greenland</option>
                                                            <option value="Grenada">Grenada</option>
                                                            <option value="Guadeloupe">Guadeloupe</option>
                                                            <option value="Guam">Guam</option>
                                                            <option value="Guatemala">Guatemala</option>
                                                            <option value="Guinea">Guinea</option>
                                                            <option value="Guyana">Guyana</option>
                                                            <option value="Haiti">Haiti</option>
                                                            <option value="Hawaii">Hawaii</option>
                                                            <option value="Honduras">Honduras</option>
                                                            <option value="Hong Kong">Hong Kong</option>
                                                            <option value="Hungary">Hungary</option>
                                                            <option value="Iceland">Iceland</option>
                                                            <option value="India">India</option>
                                                            <option value="Indonesia">Indonesia</option>
                                                            <option value="Iran">Iran</option>
                                                            <option value="Iraq">Iraq</option>
                                                            <option value="Ireland">Ireland</option>
                                                            <option value="Isle of Man">Isle of Man</option>
                                                            <option value="Israel">Israel</option>
                                                            <option value="Italy">Italy</option>
                                                            <option value="Jamaica">Jamaica</option>
                                                            <option value="Japan">Japan</option>
                                                            <option value="Jordan">Jordan</option>
                                                            <option value="Kazakhstan">Kazakhstan</option>
                                                            <option value="Kenya">Kenya</option>
                                                            <option value="Kiribati">Kiribati</option>
                                                            <option value="Korea North">Korea North</option>
                                                            <option value="Korea Sout">Korea South</option>
                                                            <option value="Kuwait">Kuwait</option>
                                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                            <option value="Laos">Laos</option>
                                                            <option value="Latvia">Latvia</option>
                                                            <option value="Lebanon">Lebanon</option>
                                                            <option value="Lesotho">Lesotho</option>
                                                            <option value="Liberia">Liberia</option>
                                                            <option value="Libya">Libya</option>
                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                            <option value="Lithuania">Lithuania</option>
                                                            <option value="Luxembourg">Luxembourg</option>
                                                            <option value="Macau">Macau</option>
                                                            <option value="Macedonia">Macedonia</option>
                                                            <option value="Madagascar">Madagascar</option>
                                                            <option value="Malaysia">Malaysia</option>
                                                            <option value="Malawi">Malawi</option>
                                                            <option value="Maldives">Maldives</option>
                                                            <option value="Mali">Mali</option>
                                                            <option value="Malta">Malta</option>
                                                            <option value="Marshall Islands">Marshall Islands</option>
                                                            <option value="Martinique">Martinique</option>
                                                            <option value="Mauritania">Mauritania</option>
                                                            <option value="Mauritius">Mauritius</option>
                                                            <option value="Mayotte">Mayotte</option>
                                                            <option value="Mexico">Mexico</option>
                                                            <option value="Midway Islands">Midway Islands</option>
                                                            <option value="Moldova">Moldova</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Mongolia">Mongolia</option>
                                                            <option value="Montserrat">Montserrat</option>
                                                            <option value="Morocco">Morocco</option>
                                                            <option value="Mozambique">Mozambique</option>
                                                            <option value="Myanmar">Myanmar</option>
                                                            <option value="Nambia">Nambia</option>
                                                            <option value="Nauru">Nauru</option>
                                                            <option value="Nepal">Nepal</option>
                                                            <option value="Netherland Antilles">Netherland Antilles</option>
                                                            <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                            <option value="Nevis">Nevis</option>
                                                            <option value="New Caledonia">New Caledonia</option>
                                                            <option value="New Zealand">New Zealand</option>
                                                            <option value="Nicaragua">Nicaragua</option>
                                                            <option value="Niger">Niger</option>
                                                            <option value="Nigeria">Nigeria</option>
                                                            <option value="Niue">Niue</option>
                                                            <option value="Norfolk Island">Norfolk Island</option>
                                                            <option value="Norway">Norway</option>
                                                            <option value="Oman">Oman</option>
                                                            <option value="Pakistan">Pakistan</option>
                                                            <option value="Palau Island">Palau Island</option>
                                                            <option value="Palestine">Palestine</option>
                                                            <option value="Panama">Panama</option>
                                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                                            <option value="Paraguay">Paraguay</option>
                                                            <option value="Peru">Peru</option>
                                                            <option value="Phillipines">Philippines</option>
                                                            <option value="Pitcairn Island">Pitcairn Island</option>
                                                            <option value="Poland">Poland</option>
                                                            <option value="Portugal">Portugal</option>
                                                            <option value="Puerto Rico">Puerto Rico</option>
                                                            <option value="Qatar">Qatar</option>
                                                            <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                            <option value="Republic of Serbia">Republic of Serbia</option>
                                                            <option value="Reunion">Reunion</option>
                                                            <option value="Romania">Romania</option>
                                                            <option value="Russia">Russia</option>
                                                            <option value="Rwanda">Rwanda</option>
                                                            <option value="St Barthelemy">St Barthelemy</option>
                                                            <option value="St Eustatius">St Eustatius</option>
                                                            <option value="St Helena">St Helena</option>
                                                            <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                            <option value="St Lucia">St Lucia</option>
                                                            <option value="St Maarten">St Maarten</option>
                                                            <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                                                            <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                                                            <option value="Saipan">Saipan</option>
                                                            <option value="Samoa">Samoa</option>
                                                            <option value="Samoa American">Samoa American</option>
                                                            <option value="San Marino">San Marino</option>
                                                            <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                                            <option value="Senegal">Senegal</option>
                                                            <option value="Serbia">Serbia</option>
                                                            <option value="Seychelles">Seychelles</option>
                                                            <option value="Sierra Leone">Sierra Leone</option>
                                                            <option value="Singapore">Singapore</option>
                                                            <option value="Slovakia">Slovakia</option>
                                                            <option value="Slovenia">Slovenia</option>
                                                            <option value="Solomon Islands">Solomon Islands</option>
                                                            <option value="Somalia">Somalia</option>
                                                            <option value="South Africa">South Africa</option>
                                                            <option value="Spain">Spain</option>
                                                            <option value="Sri Lanka">Sri Lanka</option>
                                                            <option value="Sudan">Sudan</option>
                                                            <option value="Suriname">Suriname</option>
                                                            <option value="Swaziland">Swaziland</option>
                                                            <option value="Sweden">Sweden</option>
                                                            <option value="Switzerland">Switzerland</option>
                                                            <option value="Syria">Syria</option>
                                                            <option value="Tahiti">Tahiti</option>
                                                            <option value="Taiwan">Taiwan</option>
                                                            <option value="Tajikistan">Tajikistan</option>
                                                            <option value="Tanzania">Tanzania</option>
                                                            <option value="Thailand">Thailand</option>
                                                            <option value="Togo">Togo</option>
                                                            <option value="Tokelau">Tokelau</option>
                                                            <option value="Tonga">Tonga</option>
                                                            <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                                                            <option value="Tunisia">Tunisia</option>
                                                            <option value="Turkey">Turkey</option>
                                                            <option value="Turkmenistan">Turkmenistan</option>
                                                            <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                                                            <option value="Tuvalu">Tuvalu</option>
                                                            <option value="Uganda">Uganda</option>
                                                            <option value="Ukraine">Ukraine</option>
                                                            <option value="United Arab Erimates">United Arab Emirates</option>
                                                            <option value="United Kingdom">United Kingdom</option>
                                                            <option value="United States of America">United States of America</option>
                                                            <option value="Uraguay">Uruguay</option>
                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                            <option value="Vanuatu">Vanuatu</option>
                                                            <option value="Vatican City State">Vatican City State</option>
                                                            <option value="Venezuela">Venezuela</option>
                                                            <option value="Vietnam">Vietnam</option>
                                                            <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                            <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                            <option value="Wake Island">Wake Island</option>
                                                            <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
                                                            <option value="Yemen">Yemen</option>
                                                            <option value="Zaire">Zaire</option>
                                                            <option value="Zambia">Zambia</option>
                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                        </select>
                                                    </div>
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer" style="text-align:center">
                                    <button name="update_profile" type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->

                    </div>
                    <!--/.col (left) -->

                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>