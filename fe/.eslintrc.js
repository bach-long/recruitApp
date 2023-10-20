module.exports = {
    parser: "babel-eslint",
    extends: "eslint:recommended",
    plugins: ["react", "react-hooks", "jsx-a11y"],
    rules: {
      "react/jsx-uses-react": "error",
      "react/jsx-uses-vars": "error",
      "react-hooks/rules-of-hooks": "error",
      "react-hooks/exhaustive-deps": "warn",
      "jsx-a11y/accessible-emoji": "warn",
    },
  };
