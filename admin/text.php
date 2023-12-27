<?php
include "header.php";
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">Add Category</a>
            </div>
            <div class="col-md-12">
                <!-- php -->
                <?php
                include "config.php";

                $limit = 5; // Number of records per page
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number, default is 1
                $offset = ($page - 1) * $limit; // Offset for records retrieval

                $sql = "SELECT * FROM category ORDER BY category_id DESC LIMIT {$offset}, {$limit}";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                if (mysqli_num_rows($result) > 0) {
                ?>
                    <table class="content-table">
                        <!-- Table header -->
                        <!-- ... -->
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                <!-- Display category data in table rows -->
                                <!-- ... -->
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo "<p>No categories found.</p>";
                }

                // Pagination links
                $sql_pagination = "SELECT * FROM category";
                $result_pagination = mysqli_query($conn, $sql_pagination);
                $total_records = mysqli_num_rows($result_pagination);
                $total_pages = ceil($total_records / $limit);

                echo "<ul class='pagination admin-pagination'>";
                if ($page > 1) {
                    echo "<li><a href='category.php?page=" . ($page - 1) . "'>Prev</a></li>";
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    echo "<li ";
                    if ($page == $i) {
                        echo "class='active'";
                    }
                    echo "><a href='category.php?page=" . $i . "'>" . $i . "</a></li>";
                }
                if ($total_pages > $page) {
                    echo "<li><a href='category.php?page=" . ($page + 1) . "'>Next</a></li>";
                }
                echo "</ul>";

                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
