# Elastic Export ElasticExportBelboonDE Plugin user guide

<div class="container-toc"></div>

## 1 Registering with Belboon.de

The affiliate network belboon specialises in the implementation of performance marketing measures.

## 2 Setting up the data format BelboonDE-Plugin in plentymarkets

The plugin Elastic Export is required to use this format.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **BelboonDE-Plugin**.
<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>BelboonDE-Plugin</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            Choose <b>URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.csv</b> or <b>.txt</b> for Belboon.de to be able to import the file successfully.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Active
        </td>
        <td>
            Choose <b>active</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose one or multiple order referrer. The chosen order referrer has to be active at the variation for the item to be exported.
        </td>        
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
            Choose the order referrer that should be assigned during the order import.
        </td>        
    </tr>
    <tr>
        <td>
            Offer price
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
    <tr>
        <td>
            VAT note
        </td>
        <td>
            This option is not relevant for this format.
        </td>        
    </tr>
</table>


## 3 Overview of available columns

<table>
    <tr>
        <th>
            Column name
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td>
            Merchant_ProductNumber
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> only Numbers allowed, max. 20 characters<br>
            <b>Content:</b> The variation id of the variation.
        </td>        
    </tr>
    <tr>
        <td>
            EAN_Code
        </td>
        <td>
            <b>Content:</b> According to the format setting <b>Barcode</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Title
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> According to the format setting <b>item name</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Brand
        </td>
        <td>
            <b>Content:</b> The <b>name of the manufacturer</b> of the item. The <b>external name</b> within <b>Settings » Items » Manufacturer</b> will be preferred if existing.
        </td>        
    </tr>
    <tr>
        <td>
            Price
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> max 999.999,99 <br>
            <b>Content:</b> The <b>sales price</b> of the variation.
        </td>        
    </tr>
    <tr>
        <td>
            Price_old
        </td>
        <td>
            <b>Limitation:</b> max 999.999,99 <br>
            <b>Content:</b> <b>Content:</b> The <b>sales price</b> of the price type <b>RRP</b> of the variation.
        </td>        
    </tr>
    <tr>
        <td>
            Currency
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> The ISO code of the <b>currency</b> of the price.
        </td>        
    </tr>
    <tr>
        <td>
            Valid_From
        </td>
        <td>
            <b>Content:</b> The <b>Release date</b> of the variation. 
        </td>        
    </tr>
    <tr>
        <td>
            Valid_To
        </td>
        <td>
            <b>Content:</b> The date from the setting <b>Available until</b> of the variation.
        </td>        
    </tr>
    <tr>
        <td>
            DeepLink_URL
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> The <b>URL path</b> of the item depending on the chosen <b>client</b> in the format settings.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_URL
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> URL of the image in preview size according to the format setting <b>image</b>. Variation images are prioritizied over item images.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_WIDTH
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> max 11 characters<br>
            <b>Content:</b> The width of the image from <b>Image_Small_URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Small_HEIGHT
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> max 11 characters<br>
            <b>Content:</b> The height of the image from <b>Image_Small_URL</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_URL
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> URL of the image according to the format setting <b>image</b>. Variation images are prioritizied over item images.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_WIDTH
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> max 11 characters<br>
            <b>Content:</b> The width of the image from <b>Image_Large_WIDTH</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Image_Large_HEIGHT
        </td>
        <td>
            <b>Required</b><br>>
            <b>Limitation:</b> max 11 characters<br>
            <b>Content:</b> The height of the image from <b>Image_Large_WIDTH</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Merchant Product Category
        </td>
        <td>
            <b>Content:</b> The <b>category path of the default cateogory</b> for the defined client in the format settings.
        </td>        
    </tr>
    <tr>
        <td>
            Keywords
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> Meta keywords of the item from <b>Tab: Texts</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Description_Short
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> According to the format setting <b>Preview text</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Product_Description_Long
        </td>
        <td>
            <b>Content:</b> According to the format setting <b>Description</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Last_Update
        </td>
        <td>
            <b>Content:</b> Date of the last update of the variation.
        </td>        
    </tr>
    <tr>
        <td>
            Shipping
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> According to the format setting <b>shipping costs</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Availability
        </td>
        <td>
            <b>Required</b><br>>
            <b>Content:</b> Translation according to the format setting <b>Override item availabilty</b>.
        </td>        
    </tr>
    <tr>
        <td>
            Unit_Price
        </td>
        <td>
            <b>Content:</b> The <b>base price information</b> in the format "price / unit". (Example: 10,00 EUR / kilogram)
        </td>        
    </tr>
</table>

## 4 License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-belboon-de/blob/master/LICENSE.md).
