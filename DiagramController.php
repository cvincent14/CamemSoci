<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

use DB;

class DiagramController extends Controller
{
    private $BDDgraph;

    public function DiagramTotalHtParSociete($id)
    {
        $this->BDDgraph = DB::connection('BDDgraph');

        $detailMonthSociety = $this->BDDgraph->select(
            'SELECT
            SUM(TotalHt) AS totalHt, date
            FROM (
            SELECT SUM(bon.total_ht_bc) AS TotalHt, LEFT(bon.creation_dateheure,7) AS date 
            FROM bon
            WHERE(SUBDATE(CURDATE(), INTERVAL 12 MONTH) <= validation_dateheure)
            AND bon.id_fournisseur = :id
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
        
        $detailLastYearSociety = $this->BDDgraph->select(
            'SELECT
            SUM(TotalHt) AS totalHt, date
            FROM (
            SELECT SUM(bon.total_ht_bc) AS TotalHt, LEFT(bon.creation_dateheure,7) AS date 
            FROM bon
            WHERE(SUBDATE(CURDATE(), INTERVAL 24 MONTH) <= validation_dateheure)
            AND (SUBDATE(CURDATE(), INTERVAL 12 MONTH) > validation_dateheure)
            AND bon.id_fournisseur = :id
            AND bon.validation_etat>3
            GROUP BY date
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 24 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 23 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 22 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 21 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 20 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 19 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 18 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 17 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 16 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 15 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 14 MONTH),7)
            UNION SELECT 0, LEFT(SUBDATE(CURDATE(), INTERVAL 13 MONTH),7)
            ) AS MAINREQ
            GROUP BY date', ['id' => $id]);
 
        return [
            'detailMonthSociety' => $detailMonthSociety,
            'detailLastYearSociety' => $detailLastYearSociety,
        ];
    }

    public function DiagramImputation($id)
    {
        $this->BDDgraph = DB::connection('BDDgraph');

        $totalImputation = $this->BDDgraph->select(
            'SELECT SUM(bon.total_ht_bc/bon.taux_de_change) AS totalHt, Lib_FR
            FROM bon, imputation_2
            WHERE bon.id_imp2 = imputation_2.IDImputation_2
            AND(SUBDATE(CURDATE(), INTERVAL 12 MONTH) <= validation_dateheure)
            AND bon.id_fournisseur = :id
            AND bon.validation_etat > 3
            GROUP BY IDImputation_2
            ORDER BY totalHt DESC', ['id' => $id]);
 
        return ['totalImputation' => $totalImputation];
    }

}
