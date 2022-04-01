//--> start of Dashboard js <--//
if ($("#divMain").children().length == 0) {
    $(document).ready(function () {
        $("#divMain").load("/dashboard");
    });
}

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

//if (sessionStorage.getItem("route")) {
//    $("#divMain").load(sessionStorage.getItem("route"));
//} else {
//    $("#divMain").load("/dashboard");
//}
//--> End of Dashboard js <--//

function slideAlert(message, alert_appear) {
    $(alert_appear)
        .fadeTo(3500, 500)
        .slideUp(500, function () {
            $(alert_appear).slideUp(500);
        });
    $(alert_appear).html(message);
}

console.log($("#permissions").val());

$(document).ready(function () {
    $("body").on("click", ".menu", function () {
        if (!$("#tabs").length) {
            $("#divMain").html(
                `<ul class="nav nav-tabs" id="tabs"></ul>
        <div class="tab-content border-secondary" id="contents"></div>`
            );
        }
        var name = $(this).attr("data-name");
        var moduleWithSpace;
        if (name == undefined) {
            moduleWithSpace = $(this).text().trim();
        } else {
            moduleWithSpace = name;
        }

        var moduleWOSpace = moduleWithSpace.replace(/\s+/g, "");
        var menu = moduleWOSpace;
        //checks if the clicked item has its tab is shown
        if (!$(`#tab${menu}`).length) {
            loadTab(menu, moduleWithSpace);
        }
        // if it's active, show it
        else {
            $(`#tab${menu}`).tab("show");
        }
    });
    // function for the close button of the tabs
    $("body").on("click", ".closeTab", function () {
        var $item = $(this).parent().text().trim();
        // if there are no shown tabs, remove all elements
        if (!$("#tabs li").length) {
            $("#divMain").html("");
        } else {
            $(".menu-item").each(function (index) {
                if ($(this).text().trim() == $item) {
                    // checks for the previous sibling if it has one
                    var goTo = $(this).prev().text().trim().length
                        ? $(this).prev().children().attr("id")
                        : $(this).next().children().attr("id");
                    $(`#${goTo}`).tab("show");
                }
            });
        }
        $(this).parent().parent().remove();
        $($(this).parent().attr("href")).remove();

        //--> Additional Dashboard js (close tabs) <--//
        if ($("#tabs").children().length == 0) {
            $(document).ready(function () {
                $("#divMain").load("/dashboard");
            });
        }
        //--> End of Dashboard js (close tabs) <--//
    });
});

function loadTab(menu, moduleWithSpace) {
    $("#tabs").append(
        `<li class="nav-item menu-item">
    <a class="nav-link" data-toggle="tab" href="#content${menu}" id="tab${menu}">
          ${moduleWithSpace} <b class="closeTab text close ml-4">x</b>
    </a>
</li>`
    );
    // append the content of the tab
    $("#contents").append(
        `<div class="tab-pane active p-0" id="content${menu}">
</div>`
    );
    //goes to a specific module
    var $link = `${menu}`;
    var $parent = $(this).attr("data-parent");
    // set custom module route defined in data-module attribute
    if (typeof $(this).attr("data-module-url") !== "undefined") {
        $link = $(this).attr("data-module-url");
    }
    var linkString = "/" + $link.toLowerCase();
    $(`#content${menu}`).load(
        linkString,
        function (responseTxt, statusTxt, xhr) {
            if (statusTxt == "error") {
                console.log("Error: " + xhr.status + ": " + xhr.statusText);
                console.log($parent);
                $(`#content${menu}`).load(
                    linkString,
                    function (responseTxt, statusTxt, xhr) {
                        if (statusTxt == "error")
                            alert(
                                "Error: " + xhr.status + ": " + xhr.statusText
                            );
                    }
                );
            }
            //console.log(linkString);
            sessionStorage.setItem("route", linkString);
            sessionStorage.setItem("menuString", menu);
            sessionStorage.setItem("moWSpace", moduleWithSpace);
        }
    );
    $(`#tab${menu}`).tab("show");
}

function openNewWorkorder() {
    $(document).ready(function () {
        $("#contentWorkOrder").load("/openNewWorkorder");
    });
}

function openBlueprint() {
    $(document).ready(function () {
        $("#contentBOM").load("/openBlueprint");
    });
}
function openInventoryInfo() {
    $(document).ready(function () {
        $("#contentInventory").load("/openInventoryInfo");
    });
}

function loadInv() {
    $(document).ready(function () {
        $("#contentInventory").load("/inventory");
    });
}

function loadComponent() {
    $(document).ready(function () {
        $("#contentComponent").load("/component");
    });
}

function loadWorkOrder() {
    $(document).ready(function () {
        $("#contentWorkOrder").load("/workorder");
    });
}

function loadReportsBuilder() {
    $(document).ready(function () {
        $("#contentReportsBuilder").load("/reportsbuilder");
    });
}
function loadReportsBuilderShowReport() {
    $(document).ready(function () {
        $("#contentReportsBuilder").load("/loadReportsBuilderShowReport");
    });
}

function openReportsBuilderForm() {
    $(document).ready(function () {
        $("#contentReportsBuilder").load("/openReportsBuilderForm");
    });
}

function loadManufacturingProductionPlan() {
    $(document).ready(function () {
        $("#contentProductionPlan").load("/productionplan");
    });
}

function openManufacturingProductionPlanForm() {
    $(document).ready(function () {
        $("#contentProductionPlan").load(
            "/openManufacturingProductionPlanForm"
        );
    });
}

function loadManufacturingWorkstation() {
    $(document).ready(function () {
        $("#contentWorkstation").load("/workstation");
    });
}
function openManufacturingWorkstationForm() {
    $(document).ready(function () {
        $("#contentWorkstation").load("/openManufacturingWorkstationForm");
    });
}

function loadManufacturingRouting() {
    $(document).ready(function () {
        $("#contentRouting").load("/routing");
    });
}
function openManufacturingRoutingForm() {
    $(document).ready(function () {
        $("#contentRouting").load("/routing/create");
        $("#contentNewRouting").load("/routing/create");
    });
}

function loadProjectsTimesheet() {
    $(document).ready(function () {
        $("#contentTimesheet").load("/loadProjectsTimesheet");
    });
}
function openManufacturingTimesheetForm() {
    $(document).ready(function () {
        $("#contentTimesheet").load("/openManufacturingTimesheetForm");
    });
}

function loadManufacturingItemAttribute() {
    $(document).ready(function () {
        $("#contentItemAttribute").load("/itemattribute");
    });
}
function openManufacturingItemAttributeForm() {
    $(document).ready(function () {
        $("#contentItemAttribute").load("/openManufacturingItemAttributeForm");
    });
}

function loadManufacturingItemPrice() {
    $(document).ready(function () {
        $("#contentItemPrice").load("/itemprice");
    });
}
function openManufacturingItemPriceForm() {
    $(document).ready(function () {
        $("#contentItemPrice").load("/openManufacturingItemPriceForm");
    });
}

function loadBuyingRequestForQuotation() {
    $(document).ready(function () {
        $("#contentRequestforQuotation").load("/requestforquotation");
    });
}
function openBuyingRequestForQuotationForm() {
    $(document).ready(function () {
        $("#contentRequestforQuotation").load("/new-quotation");
    });
}
function viewBuyingRequestForQuotationForm() {
    $(document).ready(function () {
        $("#contentRequestforQuotation").load("/view-quotation");
    });
}

function loadSupplier() {
    $(document).ready(function () {
        $("#contentSupplier").load("/supplier");
    });
}

function openSupplierInfo(id) {
    $(document).ready(function () {
        $("#contentSupplier").load(`/supplier/${id}`);
    });
}

function openSupplierForm() {
    $(document).ready(function () {
        $("#contentSupplier").load(`/supplier/create`);
    });
}

function openSaleInfo(id) {
    $(document).ready(function () {
        $("#contentSalesOrder").load(`/view-sales-order/${id}`);
    });
}

function loadSalesOrder() {
    $(document).ready(function () {
        $("#contentSalesOrder").load("/salesorder");
    });
}
function openNewSaleOrder(x) {
    $(document).ready(function () {
        $("#contentSalesOrder").load("/openNewSaleOrder");
    });
}

function loadPurchaseOrder() {
    $(document).ready(function () {
        $("#contentPurchaseOrder").load("/purchaseorder");
    });
}

function viewPurchaseOrder(id) {
    $(document).ready(function () {
        $("#contentPurchaseOrder").load(`/purchaseorder/${id}`);
    });
}

function openNewPurchaseOrder() {
    $(document).ready(function () {
        $("#contentPurchaseOrder").load("/purchaseorder/create");
    });
}

function loadMaterialRequest() {
    $(document).ready(function () {
        $("#contentMaterialRequest").load("/materialrequest");
    });
}

function openNewMaterialRequest() {
    $(document).ready(function () {
        $("#contentMaterialRequest").load("/materialrequest/create");
    });
}

function openMaterialRequestInfo() {
    $(document).ready(function () {
        $("#contentMaterialRequest").load("/openMaterialRequestInfo");
    });
}

function loadJobsched() {
    $(document).ready(function () {
        $("#contentJobScheduling").load("/loadJobsched");
    });
}

function loadJobschedhome() {
    $(document).ready(function () {
        $("#contentJobScheduling").load("/jobscheduling");
    });
}

function loadUOM() {
    $(document).ready(function () {
        $("#contentUOM").load("/uom");
    });
}

function openUOMNew() {
    $(document).ready(function () {
        $("#contentUOM").load("/openUOMNew");
    });
}

function openUOMEdit() {
    $(document).ready(function () {
        $("#contentUOM").load("/openUOMEdit");
    });
}

function openNewStockEntry() {
    $(document).ready(function () {
        $("#contentStockEntry").load("/openNewStockEntry");
    });
}

function loadStockEntry() {
    $(document).ready(function () {
        $("#contentStockEntry").load("/loadStockEntry");
    });
}

function loadStockMoves() {
    $(document).ready(function () {
        $("#contentStockMoves").load("/stockmoves");
    });
}

function openNewTask() {
    $("#contentTask").load("/openNewTask");
}

function loadTask() {
    $("#contentTask").load("/task");
}

function openNewPriceList() {
    $("#contentPriceList").load("/openNewPriceList");
}

function openSalesInvoiceItem() {
    $(document).ready(function () {
        $("#contentSalesInvoice").load("/sales-invoice-item");
    });
}

function loadSalesInvoice() {
    $(document).ready(function () {
        $("#contentSalesInvoice").load("/salesinvoice");
    });
}

function loadPriceList() {
    $("#contentPriceList").load("/loadPriceList");
}

function openNewProjectTemplate() {
    $("#contentProjectTemplate").load("/openNewProjectTemplate");
}

function loadProjectTemplate() {
    $("#contentProjectTemplate").load("/loadProjectTemplate");
}

function loadWarehouse() {
    $(document).ready(function () {
        $("#contentWarehouse").load("/loadWarehouse");
    });
}

function openWarehouseNew() {
    $(document).ready(function () {
        $("#contentWarehouse").load("/openWarehouseNew");
    });
}

function openWarehouseEdit() {
    $(document).ready(function () {
        $("#contentWarehouse").load("/openWarehouseEdit");
    });
}

function openItemVariantSettings() {
    $(document).ready(function () {
        $("#contentItemVariantSetting").load("/openItemVariantSettings");
    });
}

function loadPendingOrders() {
    $(document).ready(function () {
        $("#contentPendingOrders").load("/pendingorders");
    });
}

function openPendingOrdersInfo() {
    $(document).ready(function () {
        $("#contentPendingOrders").load("/view-pending-order");
    });
}

function openDeliveryInfo() {
    $(document).ready(function () {
        $("#contentDelivery").load("/view-delivery-info");
    });
}

function loadDelivery() {
    $(document).ready(function () {
        $("#contentDelivery").load("/delivery");
    });
}

function loadSupplierQuotationInfo() {
    $(document).ready(function () {
        $("#contentSupplierQuotation").load("/load-supplier");
    });
}

function loadSupplierQuotation() {
    $(document).ready(function () {
        $("#contentSupplierQuotation").load("/supplierquotation");
    });
}

function openNewSupplierQuotation() {
    $(document).ready(function () {
        $("#contentSupplierQuotation").load("/new-supplier");
    });
}

function openNewPurchaseInvoice() {
    $(document).ready(function () {
        $("#contentPurchaseInvoice").load("/purchaseinvoice/create");
    });
}

function loadPurchaseInvoice() {
    $(document).ready(function () {
        $("#contentPurchaseInvoice").load("/purchaseinvoice");
    });
}

function openPurchaseInvoiceInfo(id) {
    $(document).ready(function () {
        $("#contentPurchaseInvoice").load(`/purchaseinvoice/${id}`);
    });
}

function openNewPurchaseReceipt() {
    $(document).ready(function () {
        $("#contentPurchaseReceipt").load("/purchasereceipt/create");
    });
}

function openPurchaseReceiptInfo(id) {
    $(document).ready(function () {
        $("#contentPurchaseReceipt").load(`/purchasereceipt/${id}`);
    });
}

function loadPurchaseReceipt() {
    $(document).ready(function () {
        $("#contentPurchaseReceipt").load("/purchasereceipt");
    });
}
function openNewShippingRule() {
    $(document).ready(function () {
        $("#contentShippingRule").load("/shippingruleinfo");
    });
}
function loadShippingInfo() {
    $(document).ready(function () {
        $("#contentShippingRule").load("/shippingrule");
    });
}
function loadPurchaseTaxes() {
    $(document).ready(function () {
        $("#contentPurchaseTaxes").load("/purchasetaxes");
    });
}
function openNewPurchaseTaxes() {
    $(document).ready(function () {
        $("#contentPurchaseTaxes").load("/purchasetaxesinfo");
    });
}
function openNewSalesTaxes() {
    $(document).ready(function () {
        $("#contentSalesTaxes").load("/newsalestaxes");
    });
}
function loadSalesTaxes() {
    $(document).ready(function () {
        $("#contentSalesTaxes").load("/salestaxes");
    });
}
function newPricingRule() {
    $(document).ready(function () {
        $("#contentPricingRule").load("/PricingRuleInfo");
    });
}
function loadPricingRule() {
    $(document).ready(function () {
        $("#contentPricingRule").load("/pricingrule");
    });
}
function openSupplierGroup() {
    $(document).ready(function () {
        $("#contentSupplierGroup").load("/suppliergroup/create");
    });
}

function loadSupplierGroup() {
    $(document).ready(function () {
        $("#contentSupplierGroup").load("/suppliergroup");
    });
}

function openSupplierGrouptable() {
    $(document).ready(function () {
        $("#contentSupplierGroup").load("/newsuppliergrouptable");
    });
}

function openNewCoupon() {
    $(document).ready(function () {
        $("#contentCouponCode").load("/newCouponCode");
    });
}

function loadCouponCode() {
    $(document).ready(function () {
        $("#contentCouponCode").load("/couponcode");
    });
}

function openCouponInfo() {
    $(document).ready(function () {
        $("#contentCouponCode").load("/openCouponInfo");
    });
}

function openNewProductBundle() {
    $(document).ready(function () {
        $("#contentProductBundle").load("/newproductbundle");
    });
}

function loadProductBundle() {
    $(document).ready(function () {
        $("#contentProductBundle").load("/productbundle");
    });
}

function openProductBundleInfo() {
    $(document).ready(function () {
        $("#contentProductBundle").load("/openProductBundleInfo");
    });
}

function openAddressInfo() {
    $(document).ready(function () {
        $("#contentAddress").load("/openAddressInfo");
    });
}

function openNewAddress() {
    $(document).ready(function () {
        $("#contentAddress").load("/newAddress");
    });
}

function loadAddress() {
    $(document).ready(function () {
        $("#contentAddress").load("/address");
    });
}

function loadBOMForm() {
    $(document).ready(function () {
        $("#contentBom").load("/bom/create");
    });
}

function loadBOM(id) {
    $(document).ready(function () {
        $("#contentBom").load(`/bom/${id}`);
    });
}

function loadBOMtable() {
    $(document).ready(function () {
        $("#contentBom").load("/bom");
    });
}

function loadmachineinfo(id) {
    $(document).ready(function () {
        $("#contentMachineManual").load(`/machinemanual/${id}`);
    });
}

function loadNewMachineManual() {
    $(document).ready(function () {
        $("#contentMachineManual").load("/machinemanual/create");
    });
}

function loadmachine() {
    $(document).ready(function () {
        $("#contentMachineManual").load("/machinemanual");
    });
}

function loadnewworkcenter() {
    $(document).ready(function () {
        $("#contentNewRouting").load("/workcenter");
        $("#contentRouting").load("/workcenter");
    });
}

function createnewworkcenter() {
    $(document).ready(function () {
        $("#contentWorkCenter").load("/workcenter/create");
    });
}

function loadworkcenterlist() {
    $(document).ready(function () {
        $("#contentWorkCenter").load("/workcenter");
    });
}

function editworkcenter(id) {
    $(document).ready(function () {
        $("#contentWorkCenter").load(`/workcenter/${id}`);
    });
}

function loadnewRouting() {
    $(document).ready(function () {
        $("#contentRouting").load("/routing/create");
    });
}

function EditRouting(id) {
    $(document).ready(function () {
        $("#contentRouting").load(`/editrouting/${id}`);
    });
}

function RoutingTable() {
    $(document).ready(function () {
        $("#contentRouting").load("/routing");
    });
}

function newoperation() {
    $(document).ready(function () {
        $("#contentOperations").load("/operations/create");
    });
}

function operationtable() {
    $(document).ready(function () {
        $("#contentOperations").load("/operations");
    });
}

function editoperation(id) {
    $(document).ready(function () {
        $("#contentOperations").load(`/operations/${id}/edit`);
    });
}

function repairtable() {
    $(document).ready(function () {
        $("#contentRepair").load("/repair");
    });
}
function newrepairrequest() {
    $(document).ready(function () {
        $("#contentRepair").load("/newrepairrequest");
    });
}
function repairinfo(id) {
    $(document).ready(function () {
        $("#contentRepair").load("/repairinfo/" + id);
    });
}

function addEmployee() {
    $(document).ready(function () {
        $("#contentEmployee").load("/addemployee");
    });
}
function Employee() {
    $(document).ready(function () {
        $("#contentEmployee").load("/employee");
    });
}
