<?php
require_once '../config.php';
use BookWorms\Model\Product;
use BookWorms\Model\Image;
use BookWorms\Model\FileUpload;

try{
    $rules = [
        "product_id" => 'present|integer|min:1',
        "name" => "present|minlength:4|maxlength:64",
        "description" => "present|minlength:10|maxlength:256",
        "price" => "present|minlength:2|maxlength:10",
        "category" => "present|minlength:2|maxlength:10",
        "color" => "present|minlength:2|maxlength:10"
    ];

    $request->validate($rules);
    if($request->is_valid()){

        $image = null;
        if (FileUpload::exists('profile')){
            $file = new FileUpload("profile");
            $file_path = $file->get();
            $image = new Image();
            $image->path = $file_path;
            $image->save();
        }

        $product = Product::findById($request->input('product_id'));
        $product->name = $request->input("name");
        $product->description = $request->input("description");
        $product->price = $request->input("price");
        $product->category = $request->input("category");
        $product->color = $request->input("color");
        $product->image_id = $image->id;
        $product-> save();

        $request->session()->set("flash_message", "The product was successfully updated");
        $request->session()->set("flash_message_class", "alert-info");
        $request->session()->forget("flash_data");
        $request->session()->forget("flash_errors");

        $request->redirect("../views/admin/products/index.php");
    }
    else {
        $product_id = $request->input('product_id');
        $request->session()->set("flash_data", $request->all());
        $request->session()->set("flash_errors", $request->errors());

        $request->redirect("/product-edit.php?product_id=".$product_id);
    }
}

catch (Exception $ex) {
    $product_id = $request->input('product_id');
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());

    $request->redirect("/product-edit.php?product_id=".$product_id);

}