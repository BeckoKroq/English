<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\User;
use App\Dia;
use App\UpdateDias;
use App\UpdateGrupos;
use App\UserAlum_Grup;
use App\UserDoc_Grup;
use App\DatosDocente;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $grupos = Grupo::paginate(10);
        return view ('grupos.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request);
        $grupo = Grupo::create([
          'nombre_grupo' => $request['nombre_grupo'],
          'periodo' => $request['periodo'],
          'nivel' => $request['nivel'],
          'docente' => $request['docente'],
          'capacidad' => $request['capacidad'],
        ]);

        return redirect()->route('grupos.index', $grupo->id)
        ->with('info', 'Grupo guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function show(Grupo $grupo)
    {
        //
        $users = User::all();
        return view('grupos.show', compact('grupo','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        //
        //dd($grupo);
        return view('grupos.edit', compact('grupo'));
    }

    public function dias(Grupo $grupo)
    {
        $users = User::all();
        $doc = DatosDocente::all();
        $docentes=array();
        $i=0;
        foreach ($doc as $d) {
            foreach ($users as $use) {
                if($d->user_id==$use->id){
                    //echo($d.' '.$use->id);
                    $docentes[$i]=$use->name;
                    $i++;
                }
            }
        }
        //dd($docentes);
        //dd($grupo);
        return view('dias.create',compact('grupo','docentes'));
    }

    public function agreDias(Request $request,Grupo $grupo)
    {
        //
        foreach ($request['dias'] as $dia) {
            # code...
            switch ($dia) {
                case 'Lunes':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->lunes = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'lunes' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                case 'Martes':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->martes = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'martes' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                case 'Miercoles':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->miercoles = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'miercoles' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                case 'Jueves':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->jueves = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'jueves' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                case 'Viernes':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->viernes = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'viernes' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                case 'Sabado':
                    # code...
                    $hay=DB::table('dias')->where('grupos_id',$grupo->id)->pluck('id');
                    if(count($hay)>0){
                        $apro = UpdateDias::find($hay[0]);
                        $apro->sabado = $request['horainicio'].'-'.$request['horafin'];
                        $apro->save();
                    }else{
                        Dia::create([
                            'sabado' => $request['horainicio'].' a '.$request['horafin'],
                            'grupos_id' => $grupo->id,
                          ]);
                    }
                    break;
                default:
                    # code...

                    break;
            }
        }
        return redirect()->route('grupos.index', $grupo->id)
        ->with('info', 'Grupo guardado');
    }

    public function agreAlum(Request $request,Grupo $grupo)
    {
        $idUser=DB::table('datos_alumnos')->where('numcontrol',$request['numcontrol'])->pluck('user_id');
        $hay=DB::table('user_alum__grups')->where('user_id',$idUser[0])->pluck('user_id');
        $capaciadGrup=DB::table('grupos')->where('id',$grupo->id)->pluck('capacidad');
        if($capaciadGrup[0]>0){
            if(count($idUser[0])>0){
                UserAlum_Grup::create([
                    'user_id' => $idUser[0],
                    'grup_id' => $grupo->id,
                ]);
                $apro = UpdateGrupos::find($grupo->id);
                $apro->capacidad = (int)$capaciadGrup[0]-1;
                $apro->save();
            }else{
                return('el alumno no existe');
            }
        }else{
            return('grupo lleno');
        }
        return redirect()->route('grupos.index', $grupo->id)
        ->with('info', 'Grupo guardado');
    }

    public function agreDoc(Request $request,Grupo $grupo)
    {
        $users = User::all();
        $doc = DatosDocente::all();
        $docentes=array();
        $i=0;
        foreach ($doc as $d) {
            foreach ($users as $use) {
                if($d->user_id==$use->id){
                    //echo($d.' '.$use->id);
                    $docentes[$i]=$use->id;
                    $i++;
                }
            }
        }
        UserDoc_Grup::create([
            'user_id' => $docentes[$request['docente']],
            'grup_id' => $grupo->id,
        ]);
        return redirect()->route('grupos.index', $grupo->id)
        ->with('info', 'Grupo guardado');
    }

    public function pdf(Grupo $grupo)
    {
        $today = Carbon::now()->format('d/m/Y');
        return view('grupos.pdf', compact('grupo','today','grupo'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grupo $grupo)
    {
        //
        //dd($grupo);
        $grupo->update($request->all());

        return redirect()->route('grupos.index', $grupo->id)
        ->with('info', 'Grupo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grupo  $grupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        //
        //dd($grupo);
        $grupo->delete();

        return back()->with('info', 'Eliminado correctamente');
    }
}
