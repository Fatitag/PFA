#ifndef SEANCE_H
#define SEANCE_H
#include <QtSql>
#include <QSqlQuery>
#include <QDialog>

namespace Ui {
class Seance;
}

class Seance : public QDialog
{
    Q_OBJECT

public:
    explicit Seance(QWidget *parent = nullptr);
    ~Seance();

private slots:
    void on_Seance_accepted();

    void on_tableWidget_cellActivated(int row, int column);

private:
    Ui::Seance *ui;
    QSqlDatabase db;



};

#endif // SEANCE_H
