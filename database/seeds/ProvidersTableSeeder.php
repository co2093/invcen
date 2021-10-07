<?php

use Illuminate\Database\Seeder;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('providers')->insert([ 'id' => '001', 'nombre' => 'INFRASAL DE EL SALVADOR SA DE CV.', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'NELSON PEÑA','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '002', 'nombre' => 'DISTRIBUIDORA EQUIS, MARINA INDUSTRIAL, SA DE CV.', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'BLANCA GONZALES','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '003', 'nombre' => 'OP EQUIPO DE OFICINA Y MAS SA DE CV', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'CARLOS MENENDES','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '004', 'nombre' => 'DISTRIBUIDORA V Y M', 'direccion' => 'CALLE LOS PLANES DE RENDEROS', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'CLAUDIA MARISOL MOLINA GARCIA','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '005', 'nombre' => 'CONDISANPABLO, SA DE CV', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'ZAYRA TORRES','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '006', 'nombre' => 'OFFICE', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'JUAN MORALES','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '007', 'nombre' => 'DIST. DE PRODUC. MEDICOS SA DE CV', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'OSWALDO','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '008', 'nombre' => 'ESERSKI HERMANOS SA DE CV', 'direccion' => 'Avenida 34, col. 46', 'telefono'=>'7777-7777', 'fax'=>'','vendedor'=>'LUZ REYES','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '009', 'nombre' => 'LA CASA DEL RESPUESTO SA DE CV', 'direccion' => 'SAN SALVADOR', 'telefono'=>'2205-1500', 'fax'=>'2281-1513','vendedor'=>'ERICK EDGARDO CERON','email'=>'mail@hotmail.com']);

       DB::table('providers')->insert([ 'id' => '010', 'nombre' => 'DIAGONAL SA DE CV', 'direccion' => 'ALAMEDA ROSSVELT Y 59 AVENIDA NORTE PSJ 5-A,', 'telefono'=>'2566-1124', 'fax'=>'','vendedor'=>'MARIA CRUZ PEÑA VIUDA DE CERON','email'=>'mail@hotmail.com']);
       
       DB::table('providers')->insert([ 'id' => '011', 'nombre' => 'INGENIERIA DE HIDROCARBUROS SA DE CV', 'direccion' => 'CALLE LAS PALMAS COL. SAN BENITO, CASA 1-7 S.S', 'telefono'=>'2511-9400', 'fax'=>'','vendedor'=>'juan carlos','email'=>'mail@hotmail.com']);
    }
}

