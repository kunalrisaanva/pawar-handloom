<?php

namespace App\Controllers\FrontendController;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;
require_once ROOTPATH . 'vendor/dompdf/autoload.inc.php'; // ✅ Load Dompdf manually
use Dompdf\Dompdf; // ✅ Correct namespace


class PdfController extends BaseController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['url','form']);

        // Check authenticate
       
    }
    public function downloadCatalogPdf($categoryId)
{
    $where = ['status' => '1','is_deleted' => '1', 'id' => $categoryId];
    $category = $this->adminModel->select_data(TBL_CATLOGCAT, $where);

    if (empty($category)) {
        return "Category not found or deleted.";
    }
    $where1 = ['status' => '1','is_deleted' => '1','cat_id' => $categoryId];
    $images = $this->adminModel->select_data(TBL_CATLOG, $where1);

    $html = view('frontend/catalog_pdf_template', [
        'categoryName' => $category[0]->catlog_category_name,
        'description'  => $category[0]->description,
        'images' => $images
    ]);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream($category[0]->catlog_category_name . ".pdf", ["Attachment" => true]);
}

}
