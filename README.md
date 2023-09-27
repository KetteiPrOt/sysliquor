# SysLiquor
This project is a prototype of an inventory management system, It was created for the liquor deposit "Licenciado".

If you are interested, you can see [detailed documentation](https://drive.google.com/drive/folders/1bVJumE2bFbjt_6-dPrMYK1_-qxz-BnnD?usp=drive_link) of this project that I developed together my friend John Santana.

This project is also the End Project Software Engineering Fundamentals (Software Engineering second level subject).

# Install
This is a PHP project building with Laravel framework.

For install this project you need a PHP server (like xampp or wampserver), composer, and Node.js in you system.

# Demo
## Login
First you will see a login screen, this is in order to only authorized users can access the system.

Log in with the default user and password that I have created: sd.kettei@gmail.com and "12345678".
![login screen](https://raw.githubusercontent.com/KetteiPrOt/sysliquor/main/storage/demo/login.jpg)
> You can cancel the creation of this user deleting the code in the DataBaseSeeder.php seeder.

## Dashboard
Once you are login, you will see a dashboard. Then go to Products section to create new products.

![dashboard screen](https://raw.githubusercontent.com/KetteiPrOt/sysliquor/main/storage/demo/panel.jpg)

## Products
In this section you can manage all products: can create, edit, and delete them, but be careful because once you have deleted a product you will delete all registers associated with them!

![products screen](https://raw.githubusercontent.com/KetteiPrOt/sysliquor/main/storage/demo/products.jpg)

## Registers
This is the most important section. Here you can manage the warehouse states that will serve to analyze how the business is working.

Each new warehouse status is created based on current products list of the Products section.

![registers screen](https://raw.githubusercontent.com/KetteiPrOt/sysliquor/main/storage/demo/register.jpg)

The system will automatically calc the sales comparing the current with the before warehouse status. In addition you have more functionalities like order by a column or search by a product name. Have much fun!