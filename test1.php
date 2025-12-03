
            <!-- <div class="container px-5 my-5">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <?php if (!empty($result_t)) {
                        foreach ($result_t as $row) {
                            $p_title = str_replace(' ', '', $row['title']);
                    ?>
                            <li class="nav-item" role="presentation" selected>
                                <button class="nav-link" id="pills-<?php echo $p_title ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $p_title ?>" type="button" role="tab" aria-controls="pills-<?php echo $p_title ?>" aria-selected="true"><?php echo $p_title ?></button>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <?php if (!empty($result_t)) {
                        foreach ($result_t as $row) {
                            $p_title = str_replace(' ', '', $row['title']);
                    ?>
                            <div class="tab-pane fade show" id="pills-<?php echo $p_title ?>" role="tabpanel" aria-labelledby="pills-<?php echo $p_title ?>-tab" tabindex="0">
                                <ul class="list-group">
                                    <?php if (!empty($result_s)) {
                                        foreach ($result_s as $rows) if ($row['title'] == $rows['title_name']) { {
                                            $p_title1 = str_replace(' ', '', $row['title']);
                                    ?>
                                                <li class="list-group-item"><?php echo $p_title1 ?></li>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div> -->