<!-- Status -->

 <h1 align="center"> 
	🚧  Reto Api Laravel 🚀 
</h1> 

<hr> 

<p align="center">
  <a href="#dart-about">About</a> &#xa0; | &#xa0; 
  <a href="#rocket-technologies">Technologies</a> &#xa0; | &#xa0;
  <a href="#white_check_mark-requirements">Requirements</a> &#xa0; | &#xa0;
  <a href="#checkered_flag-starting">Starting</a> &#xa0; | &#xa0;
  <a href="#memo-license">License</a> &#xa0; | &#xa0;
  <a href="https://github.com/{{YOUR_GITHUB_USERNAME}}" target="_blank">Author</a>
</p>

<br>

## :dart: About ##

En este proyecto hemos realizado la parte backend de una página web de una clínica dental, llamada GeeksDent

La base datos la tenemos desplegada en railway, para poder acceder a ella hay que modificar el archivo .env
Las variables son las siguientes:

DB_CONNECTION=mysql
<br>
DB_HOST=containers-us-west-156.railway.app
<br>
DB_PORT=5495
<br>
DB_DATABASE=railway
<br>
DB_USERNAME=root
<br>
DB_PASSWORD=dHxbgad6SmlIxMZWWWkn

## :rocket: Technologies ##

Las tecnologias realizadas para este proyecto han sido:

- [PHP]
- [Laravel]


## :white_check_mark: Requirements ##

Antes de comenzar :checkered_flag:, se necesita instalar el composer. Composer es un manejador de
paquetes para PHP que proporciona un
estándar para administrar, descargar e
instalar dependencias y librerías. .

## :checkered_flag: Starting ##

```bash
# Instalar laravel
$ composer global require laravel/installer

# Crear nuevo proyecto
$composer create-project laravel/laravel backend-geeksdent-laravel

# Lanzar el servidor
$ php artisan serve (lo tendremos levantado en localhost:8000)

```

## 📝 Description ##

En este proyecto final del bootcamp de FullStack Developer hemos creado la pagina web de una clínica dental, donde los usuarios podrán ver los doctores y los tratamientos que realizamos en nuestra clínica. También podrán registrar y hacer login , para poder pedir citas, y tener el seguimiento de todas las citas que han solicitado en nuestra clínica.
Para ello en nuestra base datos hemos creado las tablas, doctores, tratamientos, usuarios y citas. Aquí dejamos una imagen de las 4 tablas con su relación.



![relaciones tablas](https://user-images.githubusercontent.com/109297564/212437972-1d37762a-3fe0-4476-ac7d-4324e1697154.jpg)



El proyecto se realizó con php Laravel, y en primer lugar creamos las migraciones donde iran todos los datos de nuestra base de datos.

![Captura de pantalla 2023-01-14 004539](https://user-images.githubusercontent.com/109297564/212438245-c0a2f112-4f01-4057-95b7-778a505520c1.jpg)


Una vez creadas todas las tablas, realizaremos las migraciones. Una vez creadas las migraciones añadiremos los items que vamos a necesitar en cada tabla, y también añadiremos las relaciones entre las tablas.

Indicar que para poder crear las relaciones también hemos tenido que crear los modelos de las tablas, ya que ahi indicaremos la relación existente.

![ejemplo modelo](https://user-images.githubusercontent.com/109297564/212437948-19bf0975-b763-47d1-a368-5b7b76a42032.jpg)


A continuacion y para empezar con los endpoints añadiremos las rutas necesarias para cada uno de los endpoints necesarios para que la aplicación sea totalmente funcional.

Estas rutas iran en el archivo api.php que se encuentra alojado en la carpeta routes.

![Captura de pantalla 2023-01-19 171758](https://user-images.githubusercontent.com/109297564/213495722-05e2e193-13ec-4089-892b-491c2b2c1bfa.jpg)


Y para poder darle funcionalIdad a cada una de estas rutas, crearemos los controllers, donde crearemos toda la lógica para poder obtener todos los endpoints

![Captura de pantalla 2023-01-14 004401](https://user-images.githubusercontent.com/109297564/212438156-d10e23c8-0ed5-4e45-ba49-ec9fb8eb51e7.jpg)


Como vemos en la imagen los  controllers se encuentran en la carpeta HTTP, que estará ubicada dentro de app.


![estructura del proyecto](https://user-images.githubusercontent.com/109297564/212438178-67cb4975-3c7f-49c9-a7cc-4767d32c8e35.jpg)


Para poder comprobar que todos nuestros ENDPOINTS funcionan, crearemos una colección en Postman con todos ellos.


![Captura de pantalla 2023-01-14 004224](https://user-images.githubusercontent.com/109297564/212438031-6b3b9a3a-c469-4621-9142-3b18b3f1a693.jpg)



Una vez probados todos los endpoints ya tenemos un backend funcional, para la aplicación.

## ENDPOINTS ##

//AUTH
Route::group([
    'middleware'=>
     <br>'cors'
],
 <br>
 function(){
 <br>
    Route::post('/register', [AuthController::class, 'register'])
     <br>
     le pasaremos un body de este tipo
     {
  "name":"Luis",
            "surname":"Catala",
             "email":"luis@luis.com",
            "password":"luis1234",
            "phone":"666555444"
}
<br>
Route::post('/login', [AuthController::class, 'login']);
<br>
le pasaremos un body de este tipo
{"email:"nacho@nacho.com",
"password":"Nacho1234"}

});
Route::group([
    'middleware' =>
     <br>['jwt.auth', 'cors']
], 
 <br>function () {
 <br>
    Route::post('/logout', [AuthController::class, 'logout']);
     <br>
    Route::get('/profile', [AuthController::class, 'profile']);
    <br>
    Route::put('/updateUser', [UserController::class,'updateUser']);
 <br>
 le pasaremos un body de este tipo
 {
            "name":"Ignacio",
            "surname":"Garcia Valero",
            "phone":"111111111"
}
});



Route::get('/doctors', [DoctorController::class, 'doctors']);
 <br>
Route::get('/treatments', [TreatmentController::class, 'treatments']);


//ADMIN
Route::group([
    'middleware' =>
    <br>
    ['jwt.auth','admin.auth', 'cors']
],
<br>
function () {
<br>
    Route::get('/admin', [AdminController::class, 'index']);
    <br>
    Route::get('/users', [AdminController::class, 'users']);
    <br>
    Route::delete('/deleteuser/{id}', [AdminController::class, 'deleteuser']);
     <br>
    Route::get('/appointments', [AdminController::class, 'appointments']);
     <br>
    Route::post('/addDoctor', [DoctorController::class, 'addDoctor']);
     <br>
  le pasaremos un body de este tipo  
{
"name":"Juan Navarro",
"especialidad":"implantes"
}
<br>
    Route::delete('/deleteDoctor/{id}', [DoctorController::class, 'deleteDoctor']);
     <br>
    Route::post('/addTreatment', [TreatmentController::class, 'addTreatment']);
     <br>
     le pasremos este body
       {
        "name":"all on 4"
        }
     <br>
    Route::delete('/deleteTreatment/{id}', [TreatmentController::class, 'deleteTreatment']);
     <br>
});



//APPOINTMENTS

Route::group([
    'middleware' =>
    <br>
   ['jwt.auth', 'cors'] 
], 
<br>
function () {
<br>
    Route::post('/addAppointment', [AppointmentController::class, 'addAppointment']);
    <br>
   le pasaremos un body de este tipo
     {"date":"2023-1-26",
       //"reason":"Colocación de brackets",
       //"doctorsId":"2",
       //"treatmentsId":"6"}
       <br>
       <br>
    Route::get('/myAppointments', [AppointmentController::class, 'myAppointments']);
    <br>
    Route::put('/updateAppointment', [AppointmentController::class, 'updateAppointment']);
    <br>
    <br>
  le pasaremos un body de este tipo
    / {"date":"2023-1-26",
       //"reason":"Colocación de brackets",
       //"doctorsId":"2",
       //"treatmentsId":"6"}
       <br>
       <br>
    Route::delete('/deleteAppointment', [AppointmentController::class, 'deleteAppointment']);
});


## :memo: License ##

Este proyecto ha sido realizado por <a href="https://github.com/Naxete7">Ignacio Garcia Valero.</a>
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
