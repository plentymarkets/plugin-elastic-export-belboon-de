# Elastic Export ElasticExportBelboonDE Plugin user guide

<div class="container-toc"></div>

## 1 Registering with Belboon.de

The affiliate network belboon specialises in the implementation of performance marketing measures.

## 2 Setting up the data format BelboonDE-Plugin in plentymarkets

By installing this plugin you will receive the export format **BelboonDE-Plugin**. Use this format to exchange data between plentymarkets and belboon. It is required to install the Plugin **Elastic export** from the plentyMarketplace first before you can use the format **BelboonDE-Plugin** in plentymarkets.

Once both plugins are installed, you can create the export format **BelboonDE-Plugin**. Refer to the [Elastic Export](https://knowledge.plentymarkets.com/en/data/exporting-data/elastic-export) page of the manual for further details about the individual format settings.

Creating a new export format:

1. Go to **Data » Elastic export**.
2. Click on **New export**.
3. Carry out the settings as desired. Pay attention to the information given in table 1.
4. **Save** the settings.<br/>
→ The export format is given an ID and it appears in the overview within the **Exports** tab.

The following table lists details for settings, format settings and recommended item filters for the format **BelboonDE-Plugin**.

| **Setting**                                           | **Explanation** | 
| :---                                                  | :--- |
| **Settings**                                          | |
| **Name**                                              | Enter a name. The export format is listed under this name in the overview within the **Exports** tab. |
| **Type**                                              | Select the type **Item** from the drop-down list. |
| **Format**                                            | Select **BelboonDE-Plugin**. |
| **Limit**                                             | Enter a number. If you want to transfer more than 9,999 data records to belboon, then the output file will not be generated again for another 24 hours. This is to save resources. If more than 9,999 data records are necessary, the setting **Generate cache file** has to be active. |
| **Generate cache file**                               | Place a check mark if you want to transfer more than 9,999 data records to belboon. The output file will not be generated again for another 24 hours. We recommend not to activate this setting for more than 20 export formats. This is to save resources. |
| **Provisioning**                                      | Select **URL**. This option generates a token for authentication in order to allow external access. |
| **Token, URL**                                        | If you have selected the option **URL** under **Provisioning**, then click on **Generate token**. The token is entered automatically. When the token is generated under **Token**, the URL is entered automatically. |
| **File name**                                         | The file name must have the ending **.csv** or **.txt** for belboon to be able to import the file successfully. |
| **Item filters**                                      | |
| **Add item filters**                                  | Select an item filter from the drop-down list and click on **Add**. There are no filters set in default. It is possible to add multiple item filters from the drop-down list one after the other.<br/> **Variations** = Select **Transfer all** or **Only transfer main variations**.<br/> **Markets** = Select one or multiple order referrers. The chosen order referrer has to be active at the variation for the item to be exported.<br/> The selected order referrer has to be active at the variation for the item to be exported.<br/> **Currency** = Select a currency.<br/> **Category** = Activate to transfer the item with its category link. Only items belonging to this category will be exported.<br/> **Image** = Activate to transfer the item with its image. Only items with images will be transferred.<br/> **Client** = Select client.<br/> **Stock** = Select which stocks you want to export.<br/> **Flag 1 - 2** = Select the flag.<br/> **Manufacturer** = Select one, several or **ALL** manufacturers.<br/> **Active** = Select **Active**. Only active variations are exported. |
| **Format settings**                                   | |
| **Product URL**                                       | Choose which URL should be transferred to belboon, the item’s URL or the variation’s URL. Variation SKUs can only be transferred in combination with the Ceres store. |
| **Client**                                            | Select a client. This setting is used for the URL structure. |
| **URL parameter**                                     | Enter a suffix for the product URL if this is required for the export. If you have activated the transfer option for the product URL further up, then this character string is added to the product URL. |
| **Order referrer**                                    | Choose the order referrer that should be assigned during the order import from the drop-down list. The selected referrer is added to the product URL so that sales can be analysed later. |
| **Marketplace account**                               | Select the marketplace account from the drop-down list. |
| **Language**                                          | Select the language from the drop-down list. |
| **Item name**                                         | Select **Name 1**, **Name 2** or **Name 3**. These names are saved in the **Texts** tab of the item. Enter a number into the **Maximum number of characters (def. Text)** field if desired. This specifies how many characters should be exported for the item name. |
| **Preview text**                                      | Select the text that you want to transfer as preview text.<br/> Enter a number into the **Maximum number of characters (def. text)** field if desired. This specifies how many characters should be exported for the preview text.<br/> Activate the option **Remove HTML tags** if you want HTML tags to be removed during the export. If you only want to allow specific HTML tags to be exported, then enter these tags into the field **Permitted HTML tags, separated by comma (def. text)**. Use commas to separate multiple tags. |
| **Description**                                       | Select the text that you want to transfer as description.<br/> Enter a number into the **Maximum number of characters (def. text)** field if desired. This specifies how many characters should be exported for the description.<br/> Activate the option **Remove HTML tags** if you want HTML tags to be removed during the export. If you only want to allow specific HTML tags to be exported, then enter these tags into the field **Permitted HTML tags, separated by comma (def. Text)**. Use commas to separate multiple tags. |
| **Target country**                                    | Select the target country from the drop-down list. |
| **Barcode**                                           | Select the ASIN, ISBN or an EAN from the drop-down list. The barcode has to be linked to the order referrer selected above. If the barcode is not linked to the order referrer it will not be exported. |
| **Image**                                             | Select **Position 0** or **First image** to export this image.<br/> **Position 0** = An image with position 0 is transferred.<br/> **First image** = The first image is transferred. |
| **Image position of the energy efficiency label**     | This option does not affect this format. |
| **Stockbuffer**                                       | The stock buffer for variations with limitation to the net stock. |
| **Stock for variations without stock limitation**     | The stock for variations without stock limitation. |
| **Stock for variations with no stock administration** | The stock for variations without stock administration. |
| **Live currency conversion**                          | Activate this option to convert the price into the currency of the selected country of delivery. The price has to be released for the corresponding currency. |
| **Retail price**                                      | Select the gross price or net price from the drop-down list. |
| **Offer price**                                       | This option does not affect this format. |
| **RRP**                                               | Activate to transfer the RRP. |
| **Shipping costs**                                    | Activate this option if you want to use the shipping costs that are saved in a configuration. If this option is activated, then you will be able to select the configuration and the payment method from the drop-down lists.<br/> Activate the option **Transfer flat rate shipping charge** if you want to use a fixed shipping charge. If this option is activated, a value has to be entered in the line underneath. |
| **VAT Note**                                          | This option does not affect this format. |
| **Item availability**                                 | Activate the **overwrite** option and enter item availabilities into the fields **1** to **10**. The fields represent the IDs of the availabilities. This will overwrite the item availabilities that are saved in the menu **Setup » Item » Availability**. |
       
_Tab. 1: Settings for the data format **BelboonDE-Plugin**_ 

## 3 Available columns of the export file

| **Column name**           | **Explanation** |
| :---                      | :--- |
| Merchant_ProductNumber    | **Required**<br/> **Limitation**: only numbers allowed, max. 20 characters<br/> The variation ID of the variation. |
| EAN_Code                  | According to the format setting **Barcode**. |
| Product_Title             | **Required**<br/> According to the format setting **Item name**. |
| Brand                     | The name of the manufacturer of the item. The **external name** within **Setup » Item » Manufacturers** is preferred if existing. |
| Price                     | **Required**<br/> **Limitation**: max. 999,999.99<br/> The sales price of the variation. |
| Price_old                 | **Limitation**: max. 999,999.999<br/> The sales price of the price type **RRP** of the variation. |
| Currency                  | **Required**<br/> The ISO code of the currency of the price. |
| Valid_From                | The release date of the variation. |
| Valid_To                  | The date from the setting **Available until** of the variation. |
| DeepLink_URL              | **Required**<br/> The URL path of the item depending on the chosen client in the format settings. |
| Image_Small_URL           | **Required**<br/> URL of the image in preview size according to the format setting **Image**. Variation images are prioritised over item images. |
| Image_Small_WIDTH         | **Required**<br/> **Limitation**: max. 11 characters<br/> The width of the image from Image_Small_URL. |
| Image_Small_HEIGHT        | **Required**<br/> **Limitation**: max. 11 characters<br/> The height of the image from Image_Small_URL. |
| Image_Large_URL           | **Required**<br/> URL of the image according to the format setting **Image**. Variation images are prioritised over item images. |
| Image_Large_WIDTH         | **Required**<br/> **Limitation**: max. 11 characters<br/> The width of the image from Image_Large_WIDTH. |
| Image_Large_HEIGHT        | **Required**<br/> **Limitation**: max. 11 characters<br/> The height of the image from Image_Large_WIDTH. |
| Merchant Product Category | The category path of the default category for the defined **client** in the format settings. |
| Keywords                  | The meta keywords of the item from the tab **Texts**. |
| Product_Description_Short | **Required**<br/>  According to the format setting **Preview text**. |
| Product_Description_Long  | According to the format setting **Description**. |
| Last_Update               | The date of the last update of the variation. |
| Shipping                  | **Required**<br/> According to the format setting **Shipping costs**. |
| Availability              | **Required**<br/> Translation according to the format setting **Overwrite item availability**. |
| Unit_Price                | The base price information in the format "price / unit" (example: 10.00 EUR / kilogram). |

## 4 License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-belboon-de/blob/master/LICENSE.md).
