<?php
include("includes/header.php");
include("includes/navstat.php");
session_start();
if(isset($_SESSION['user'])){
  header("location:backend/adminindex.php");
}else if(isset($_SESSION['role'])==1){
  header("location:frontend/teacherindex.php");
}else if(isset($_SESSION['role'])==2){
  header("location:frontend/studentindex.php");
}
?>
<div class="container-fluid" id="logincontainer"></div>
                    <div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="loginmodalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/backend/login.php" method="post">
                                    <!-- User input -->
                                    <div class="form-outline mb-4">
                                      <input type="text" id="loginUsername" name="loginUsername" class="form-control" placeholder="Username"/>
                                      <label class="form-label" for="loginUsername"></label>
                                    </div>
                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                      <input type="password" id="loginPassword" name="loginPassword" class="form-control" placeholder="Password"/>
                                      <label class="form-label" for="loginPassword"></label>
                                    </div>
                                    </div>
                                    <!-- Submit button -->
                                    <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary bg-gradient btn-block" onclick="SignInControl(event)">Log in</button>
                                    </div>
                                    <div class="text-center form-check-label mt-2">
                                        <p>Not a member?<a href="#registermodal" class="text-decoration-none ms-2"data-bs-toggle="modal" data-bs-target="#registermodal" data-bs-dismiss="modal">Register</a></p>
                                      </div>
                                  </form>
                            </div>
                          </div>
                        </div>
                      <div class="modal fade" id="registermodal" tabindex="-1" aria-labelledby="registermodalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/backend/signup.php" method="post">
                                  <!-- Role of User -->
                                  <div class="d-flex justify-content-center">
                                    <p>Register as:</p>&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="role" id="1" value="1" checked>
                                    <label class="form-check-label" for="role">Teacher</label>&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="role" id="2" value="2" >
                                    <label class="form-check-label" for="role">Student</label>
                                  </div>  
                                   <!-- Last Name input -->
                                   <div class="form-outline">
                                    <input type="text" id="registerlastName" name="registerlastName" class="form-control" placeholder="Last Name"/>
                                    <label class="form-label" for="registerlastName"></label>
                                  </div>
                                  <!-- Name input -->
                                  <div class="form-outline">
                                    <input type="text" id="registerName" name="registerName" class="form-control" placeholder="Name"/>
                                    <label class="form-label" for="registerName"></label>
                                  </div>
                                  <!-- Username input -->
                                  <div class="form-outline">
                                    <input type="text" id="registerUsername" name="registerUsername" class="form-control" placeholder="Username"/>
                                    <label class="form-label" for="registerUsername"></label>
                                  </div>
                                  <!-- Password input -->
                                  <div class="form-outline">
                                    <input type="password" id="registerPassword" name="registerPassword" class="form-control" placeholder="Password"/>
                                    <label class="form-label" for="registerPassword"></label>
                                  </div>
                                  <!-- Repeat Password input -->
                                  <div class="form-outline">
                                    <input type="password" id="registerRepeatPassword" name="registerRepeatPassword" class="form-control" placeholder="Repeat password"/>
                                    <label class="form-label" for="registerRepeatPassword"></label>
                                  </div>
                                  <!-- Email input -->
                                  <div class="form-outline">
                                    <input type="email" id="registerEmail" name="registerEmail" class="form-control" placeholder="Email"/>
                                    <label class="form-label" for="registerEmail"></label>
                                  </div>
                                  <!-- Phone input -->
                                  <div class="form-outline">
                                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="phone number: 99-999-999" pattern="[0-9]{8}" required>
                                    <label class="form-label" for="tel"></label>
                                  </div>
                                  <!-- Address input -->
                                  <div class="form-outline">
                                    <input type="text" id="add" name="add" class="form-control" placeholder="address">
                                    <label class="form-label" for="add"></label>
                                  </div>                              
                                   <!-- Submit button -->
                                   <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary bg-gradient btn-block" onclick="RegisterControl(event)">Register</button>
                                  </div>                  
                                    <div class="text-center form-check-label mt-2">
                                      <p>Already a member?<a href="#loginmodal" class="text-decoration-none ms-2" data-bs-toggle="modal" data-bs-target="#loginmodal" data-bs-dismiss="modal">Log in</a></p>
                                    </div>        
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
<?php
include("includes/footer.php");
?>