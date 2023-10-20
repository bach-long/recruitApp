import React from "react";
import { CloseCircleOutlined } from "@ant-design/icons";
import WrapSearch from "../../../component/WrapSearch";
import BoxCV from "../../../component/BoxCV";
import CustomTable from "../../../component/TableCustom";
import { Row, Col } from "antd";
import RowHorizontal from "../../../component/RowHorizontal";

const MyCompany = () => {
  const columns = [
    {
      title: "Tên công việc",
      dataIndex: "name",
      key: "name",
    },
    {
      title: "Tên công ty",
      dataIndex: "company",
      key: "company",
    },
    {
      title: "Địa điểm",
      dataIndex: "address",
      key: "address",
    },
    {
      title: "Thao tác",
      align: "center",
      key: "action",
      width: 120,
      render: (text, record) => {
        return <CloseCircleOutlined className="icon-cancel" />;
      },
    },
  ];

  return (
    <WrapSearch>
      <BoxCV title={"Nhà tuyển dụng xem hồ sơ của tôi"} isEdit={false}>
        <Col style={{ borderTop: "2px solid black", paddingTop: 30 }}>
          <RowHorizontal title={"Số nhà tuyển dụng"}>
            <Row>:0</Row>
          </RowHorizontal>
          <RowHorizontal title={"Số lượt xem"}>
            <Row>:0</Row>
          </RowHorizontal>
          <CustomTable columns={columns} />
        </Col>
      </BoxCV>
    </WrapSearch>
  );
};

export default MyCompany;
