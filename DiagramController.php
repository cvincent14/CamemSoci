<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

use DB;

class DiagramController extends Controller
{
    private $DBgraph;

    public function formulaireDiagram()
    {
        $this->DBgraph = DB::connection('BDDgraph');

        $uneSociete = $this->DBgraph->select(
            'SELECT societe, IDfournisseur, SUM(total_ht_bc) totalHt
            FROM Fournisseur, bon
            WHERE bon.id_fournisseur = fournisseur.IDfournisseur
            AND IDfournisseur IN (1)'); //A la place du '1' veulliez rentrer l'ID de la société concerné

        return view('welcome', [
            'uneSociete' => $uneSociete,
        ]);
    }

    public function recoveryDiagram($id)
    {
        $this->DBgraph = DB::connection('BDDgraph');

        $detailMonthSociety = $this->DBgraph->select(
            'SELECT
            SUM(TotalHt) AS totalHt,
            date
            FROM (
            SELECT SUM(bon.total_ht_bc) AS TotalHt, LEFT(bon.creation_dateheure,7) AS date 
            FROM bon, fournisseur
            WHERE bon.id_fournisseur = fournisseur.IDfournisseur
            AND(SUBDATE(CURDATE(), INTERVAL 12 MONTH) <= validation_dateheure)
            AND fournisseur.IDfournisseur = :id
            AND bon.validation_etat>3
            GROUP BY date
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 12 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 11 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 10 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 09 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 08 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 07 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 06 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 05 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 04 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 03 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 02 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 01 MONTH),7)
            ) AS MAINREQ
            GROUP BY date', ['id' => $id]);
 
        return ['detailMonthSociety' => $detailMonthSociety];        
    }

}
