<?php
session_start();
if(isset($_SESSION['admin_id'])==null){
      header('Location: ../login.php');
}

require_once('../vendor/autoload.php');
use App\Classes\Login;
if(isset($_GET['adminlogout'])){
      Login::adminLogout();
}
// ---login---

$message="";
use App\Classes\Database;
use App\Classes\Customer;

?>

<?php include('include/admin-main-dashboard.php');?>

<main id="main" class="main">

<!-- pagination -->
      <?php
      $per_page = 40;
      if(isset($_GET['page'])){
            $page = $_GET['page'];
      }else{
            $page = 1;
      }

      $start_form = ($page-1)*$per_page;
      
      ?>
<!-- pagination -->

<?php 

$query = "SELECT `id`, `name`, `mobile`, `email`, `division`, dl.district_name, tl.thana_name, ul.union_name, `village`, `created_at`, `updated_at` FROM personal_info pi 
INNER JOIN district_list dl ON pi.id = dl.district_id
INNER JOIN thana_list tl ON pi.id = tl.thana_id
INNER JOIN union_list ul ON pi.id = ul.union_id ORDER BY id DESC limit  $start_form, $per_page ";
$result = mysqli_query(Database::dbConnect(), $query);

?>


<div class="table-responsible">
<table class="table table-bordered text-center table-stripted table-hover" id="example">
      <thead class="bg-primary text-white">
            <th>Sl.no</th>
            <th>Name</th>
            <th>Moble</th>
            <th>Email</th>
            <th>action</th>

      </thead>
      <?php 
      $i = 1;
            while($customer = mysqli_fetch_assoc($result)){
      ?>
      <tbody>
            <tr>
                  <td><?php echo $i++ ?></td>

                  <td><?php echo $customer['name'] ?></td>
                  <td><?php echo $customer['mobile'] ?></td>
                  <td><?php echo $customer['email'] ?></td>
                  <td>
                        <a class="btn btn-secondary btn-sm " href="customerInfo-view.php?view=<?php echo $customer['id']; ?>">View </a>
                        <a class="btn btn-success btn-sm" href="customerinfo-edit.php?edit=<?php echo $customer['id']; ?>">Edit</a>

                  </td>
            </tr>
      </tbody>
      <?php } ?>
</table>
</div>

<?php
$query = "SELECT * FROM maintanance";
$result = mysqli_query(Database::dbConnect(), $query);
$total_row = mysqli_num_rows($result);
$total_pages = ceil($total_row/$per_page);

?>
<!-- pagination -->
<style>
      .pagination{
            padding: 10px;
      }
      .pagination a{
            padding: 10px;
      }
</style>

<?php echo "<span class='pagination'><a href='manage-customer.php?page=1'>".'First Page '."</a>"?>

<?php
for ($i=1; $i < $total_pages; $i++) { 
      echo "<a href='manage-customer.php?page=".$i."'>".$i."</a>";
}
?>
<?php echo "<a href='manage-customer.php?page=$total_pages'>". 'Last Page'."</a> </span>" ?>

<!-- pagination -->

</main><!-- End #main -->

  <?php include('include/admin-footer.php');?>








