import { ref } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";

export default function useExport(resourceName) {
    const isExporting = ref(false);

    const handleExport = async (exportConfig) => {
        isExporting.value = true;

        try {
            const response = await axios.post(
                resourceName + "/export",
                {
                    type: {
                        type: exportConfig.type,
                        range: exportConfig.range,
                        columns: exportConfig.columns,
                        start: exportConfig.start,
                        end: exportConfig.end,
                    },
                },
                {
                    responseType:
                        exportConfig.type === "copy" ||
                        exportConfig.type === "print"
                            ? "json"
                            : "blob",
                }
            );

            if (exportConfig.type === "copy") {
                await navigator.clipboard.writeText(
                    JSON.stringify(response.data.data, null, 2)
                );
                toast.success("Data copied to clipboard!");
            } else if (exportConfig.type === "print") {
                const printWindow = window.open("", "_blank");
                printWindow.document.write(`
          <html>
            <head>
              <title>Print Data</title>
              <style>
                table {
                  border-collapse: collapse;
                  width: 100%;
                  margin-bottom: 20px;
                }
                th, td {
                  border: 1px solid #ddd;
                  padding: 12px 8px;
                  text-align: left;
                }
                th {
                  background-color: #f2f2f2;
                  font-weight: bold;
                }
                tr:nth-child(even) {
                  background-color: #f9f9f9;
                }
              </style>
            </head>
            <body>
              <table>
                <thead>
                  <tr>
                    ${Object.keys(response.data.data[0])
                        .map((header) => `<th>${header}</th>`)
                        .join("")}
                  </tr>
                </thead>
                <tbody>
                  ${response.data.data
                      .map(
                          (row) => `
                    <tr>
                      ${Object.values(row)
                          .map((cell) => `<td>${cell || ""}</td>`)
                          .join("")}
                    </tr>
                  `
                      )
                      .join("")}
                </tbody>
              </table>
            </body>
          </html>
        `);
                printWindow.document.close();
                printWindow.print();
            } else {
                const contentTypes = {
                    excel: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    csv: "text/csv",
                    pdf: "application/pdf",
                };

                const blob = new Blob([response.data], {
                    type: contentTypes[exportConfig.type],
                });

                const url = window.URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.setAttribute(
                    "download",
                    `export-${Date.now()}.${
                        exportConfig.type === "excel"
                            ? "xlsx"
                            : exportConfig.type
                    }`
                );
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);

                toast.success(
                    `${exportConfig.type.toUpperCase()} exported successfully!`
                );
            }
        } catch (error) {
            console.error("Export failed:", error);
            toast.error(
                error.response?.data?.message ||
                    "Export failed. Please try again."
            );
        } finally {
            isExporting.value = false;
        }
    };

    return { isExporting, handleExport };
}
