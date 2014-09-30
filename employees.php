<?php include_once('templates/header.php'); ?>
        
    <div class='container'>
        <div class='col-24'>
           <div class='container'>
                <div class='col-header'><p class='text-desaturated-blue padding-10'> <i class="fa fa-users fa-1x padding-left-10 text-desaturated-blue"></i> Employees</p></div>
                <nav>
                    <ul>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>View Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                        <li><a href='#'>Add Employee</a></li>
                    </ul>
               </nav>
            </div><!-- container -->
        </div><!-- col-25 -->
        <div class='col-72' id='content'>
            <div class='container'>
                <form name='add_employee' action='process/add_employee_process.php' method="post">
                   
                    <p>Personal Information</p>
                    <input class='input' type='text' name='first_name' value='' Placeholder='First Name' />
                    <input class='input' type='text' name='middle_name' value='' Placeholder='Middle Name' />
                    <input class='input' type='text' name='last_name' value='' Placeholder='Last Name' />
                    <select name='gender'>
                        <option value=''>Select Gender</option>
                        <option value='male'>Male</option>
                        <option value='female'>Female</option>
                    </select>
                    <span class='text-11'>Date of Birth</span>
                    <input class='input' type='date' name='dob' value='' Placeholder='Date of Birth' />
                    <p></p>
                    <div class='divider'></div>
                    
                    <p>Contact Information</p>
                    <input class='input' type='email' name='personal_email' value='' Placeholder='Personal Email' />
                    <input class='input' type='text' name='mobile' value='' Placeholder='Mobile Number' />
                    <p></p>
                    <div class='divider'></div>
                    
                    <p>Company Information</p>
                    <span class='text-11'>Hire Date</span> 
                    <input class='input' type='date' name='hire_date' value='' Placeholder='Hire Date' />
                    <input class='input' type='number' name='salary' value='' Placeholder='Salary' />
                </form>
            </div>
        </div><!-- col-72 -->
    </div><!-- .container -->
            
<?php include_once('templates/footer.php'); ?> 
