import React from "react";
import { Col, Row, Form } from "antd";

const FormItemHorizontal = ({
  children,
  label,
  name,
  rules,
  wrapCol = 8,
  required = false,
}) => {
  let customRules = rules;
  if (required === true && !rules) {
    customRules = [
      {
        required: true,
        message: `Missing ${label}`,
      },
    ];
  }
  return (
    <Row style={{ width: "100%" }}>
      <Form.Item
        labelCol={{ span: 8 }}
        wrapperCol={{ span: wrapCol }}
        label={
          <Col span={8} className="title-container">
            {label}
          </Col>
        }
        name={name}
        rules={customRules}
        style={{ width: "100%" }}
        required={required}
      >
        {children}
      </Form.Item>
    </Row>
  );
};

export default FormItemHorizontal;
