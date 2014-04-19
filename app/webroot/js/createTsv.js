jQuery.fn.table2TSV = function(options) {
    console.log(options);
    var options = jQuery.extend({
        separator: '\t',
        header: [],
    },
    options);
    console.log(options);

    var tsvData = [];
    var headerArr = [];
    var el = this;

    //header
    var numCols = options.header.length;
    var tmpRow = []; // construct header avalible array

    if (numCols > 0) {
        for (var i = 0; i < numCols; i++) {
            tmpRow[tmpRow.length] = formatData(options.header[i]);
        }
    } else {
        $(el).filter(':visible').find('th').each(function() {
            if ($(this).css('display') != 'none') tmpRow[tmpRow.length] = formatData($(this).html());
        });
    }

    row2TSV(tmpRow);

    // actual data
    $(el).find('tr').each(function() {
        var tmpRow = [];
        $(this).filter(':visible').find('td').each(function() {
            if ($(this).css('display') != 'none') tmpRow[tmpRow.length] = formatData($(this).html());
        });
        row2TSV(tmpRow);
    });
    if (options.output == 'popup') {
        var mydata = tsvData.join('\n');
        $.ajax({
            type: "POST",
            url: "/elearning/admin/exportPayment",
            data: {data: mydata, year: options.year, month: options.month},
            success: function(data){
            	
            }
        })
        return popup(mydata);
    } 
    if (options.output == 'raw') {
        var mydata = tsvData.join('\n');
        return mydata;
    }

    function row2TSV(tmpRow) {
        var tmp = tmpRow.join('') // to remove any blank rows
        // alert(tmp);
        if (tmpRow.length > 0 && tmp != '') {
            var mystr = tmpRow.join(options.separator);
            tsvData[tsvData.length] = mystr;
        }
    }
    function formatData(input) {
        // replace " with “
        var regexp = new RegExp(/["]/g);
        var output = input.replace(regexp, "“");
        //HTML
        var regexp = new RegExp(/\<[^\<]+\>/g);
        var output = output.replace(regexp, "");
        if (output == "") return '';
        return '"' + output + '"';
    }
    function popup(data) {
        var generator = window.open('', 'tsv', 'height=400,width=600');
        generator.document.write('<html><head><title>TSV</title>');
        generator.document.write('</head><body >');
        generator.document.write('<textArea cols=100 rows=15 wrap="off" >');
        generator.document.write(data);
        generator.document.write('</textArea>');
        generator.document.write('</body></html>');
        generator.document.close();
        return true;
    }
};