export const getLevelClass = (level) => {
    const classes = {
      ERROR: "bg-red-200 text-red-800 px-2 py-1 rounded-full",
      WARNING: "bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full",
      INFO: "bg-blue-200 text-blue-800 px-2 py-1 rounded-full",
      DEBUG: "bg-green-200 text-green-800 px-2 py-1 rounded-full",
    };

    return classes[level] || "bg-gray-200 text-gray-800 px-2 py-1 rounded-full";
  };
