<?php require_once '../config.php'; ?>
<?php

use BookWorms\Model\User;
use BookWorms\Model\Customer;
use BookWorms\Model\Role;

try {
  $rules = [
    "email" => "present|email|minlength:7|maxlength:64",
    "password" => "present|minlength:8|maxlength:64",
    "name" => "present|minlength:4|maxlength:64",
    "address" => "present|minlength:10|maxlength:256",
    "phone" => "present|minlength:10|maxlength:32"
  ];
  $request->validate($rules);

  if (!$request->is_valid()) {
    throw new Exception("Please complete the form correctly");
  }
  $email = $request->input("email");
  $password = $request->input("password");
  $name = $request->input("name");
  $address = $request->input("address");
  $phone = $request->input("phone");
  $user = User::findByEmail($email);
  if ($user !== null) {
    throw new Exception( "Email address is already registered");
  }
  $role = Role::findByTitle("customer");
  $user = new User();
  $user->email = $email;
  $user->password = password_hash($password, PASSWORD_DEFAULT);
  $user->name = $name;
  $user->role_id = $role->id;
  $user->save();

  $customer = new Customer();
  $customer->name = $name;
  $customer->address = $address;
  $customer->phone = $phone;
  $customer->user_id = $user->id;
  $customer->save();



  $request->session()->set('email', $user->email);
  $request->session()->set('name', $user->name);
  $request->session()->set('role', $role->title);
  $request->session()->forget("flash_data");
  $request->session()->forget("flash_errors");

  $request->redirect("/views"."/".$role->title."/home.php");
}
catch(Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("/views/auth/register-form.php");   
}

?>